<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTugasAkhirRequest;
use App\Models\Mahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\TugasAkhir;
use App\Services\CacheService;
use App\Services\SkpiProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\AutoResubmitPengajuan;

class MahasiswaController extends Controller
{
    use AutoResubmitPengajuan;

    public function __construct(
        private SkpiProgressService $progressService,
        private CacheService $cache
    ) {}

    public function dashboard()
    {
        $user = Auth::user();
        if (!$user->id_mahasiswa) {
            abort(403, 'User tidak terhubung ke data mahasiswa.');
        }

        $mahasiswaId = $user->id_mahasiswa;

        return $this->cache->rememberDashboard("mahasiswa:{$mahasiswaId}", function () use ($mahasiswaId) {
            $mahasiswa = Mahasiswa::with([
                'programStudi.fakultas',
                'prestasi',
                'organisasi',
                'sertifikat',
                'magang',
                'tugasAkhir.pembimbing',
                'skpi',
                'pengajuanSkpi.skpi',
                'pengajuanSkpi.checklist'
            ])->find($mahasiswaId);

            if (!$mahasiswa) {
                abort(404, 'Data mahasiswa tidak ditemukan.');
            }

            $prestasi = $mahasiswa->prestasi;
            $organisasi = $mahasiswa->organisasi;
            $sertifikat = $mahasiswa->sertifikat;
            
            $magang = $mahasiswa->magang->map(function ($item) {
                $item->tempatMagang = (object) [
                    'nama_perusahaan' => $item->tempat_magang ?? '',
                    'alamat' => '',
                ];
                return $item;
            });
            $mahasiswa->magang = $magang;

            if ($mahasiswa->skpi && $mahasiswa->skpi->dicetak_oleh) {
                $mahasiswa->skpi->printer = $this->preloader->getUser($mahasiswa->skpi->dicetak_oleh);
            }

            $pengajuan = $mahasiswa->pengajuanSkpi;
            if ($pengajuan) {
                $pengajuan->verifier = $pengajuan->diverifikasi_oleh
                    ? $this->preloader->getUser($pengajuan->diverifikasi_oleh)
                    : null;
            }

            $steps = $this->progressService->getSteps($mahasiswa, $pengajuan);

            return view('mahasiswa.dashboard.index', compact('mahasiswa', 'prestasi', 'organisasi', 'sertifikat', 'magang', 'pengajuan', 'steps'))->render();
        });
    }

    public function editTugasAkhir()
    {
        $user = Auth::user();
        if (!$user->id_mahasiswa) {
            abort(403);
        }

        $mahasiswaId = $user->id_mahasiswa;

        $mahasiswa = Mahasiswa::with(['tugasAkhir.pembimbing', 'pengajuanSkpi'])->find($mahasiswaId);

        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan.');
        }

        $tugasAkhir = $mahasiswa->tugasAkhir;
        $pengajuan = $mahasiswa->pengajuanSkpi;

        $isRejected = $tugasAkhir && $tugasAkhir->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
        $isApproved = $tugasAkhir && $tugasAkhir->status === 'approved';
        $readonly = $isLocked || $isApproved;

        if ($tugasAkhir) {
            $tugasAkhir->pembimbingTugasAkhir = $tugasAkhir->pembimbing;
        }

        $itemSteps = [
            [
                'label' => 'Diajukan',
                'done' => true,
                'icon' => 'check',
                'color' => 'bg-emerald-500',
                'info' => 'Tugas Akhir telah diisi oleh Mahasiswa',
                'note' => null,
            ]
        ];

        if ($tugasAkhir) {
            $approvals = DB::table('approvals')
                ->leftJoin('users', 'approvals.user_id', '=', 'users.id_user')
                ->where('approvable_type', 'tugas_akhir')
                ->where('approvable_id', $tugasAkhir->id_tugas_akhir)
                ->select('approvals.*', 'users.nama_lengkap')
                ->get()
                ->keyBy('role');

            $baakApproved = $tugasAkhir->status === 'approved';
            $baakRejected = $tugasAkhir->status === 'rejected';
            $baakDone = $baakApproved || $baakRejected;

            $baakApprovalRecord = $approvals->get('baak');
            $baakInfo = 'Menunggu verifikasi oleh BAAK';
            if ($baakApproved && $baakApprovalRecord) {
                $timeStr = date('d M Y H:i', strtotime($baakApprovalRecord->created_at));
                $baakInfo = "Disetujui oleh BAAK Fakultas ({$baakApprovalRecord->nama_lengkap}) - {$timeStr}";
            } elseif ($baakApproved) {
                $baakInfo = "Disetujui oleh BAAK Fakultas";
            } elseif ($baakRejected && $baakApprovalRecord) {
                $timeStr = date('d M Y H:i', strtotime($baakApprovalRecord->created_at));
                $baakInfo = "Ditolak oleh BAAK Fakultas ({$baakApprovalRecord->nama_lengkap}) - {$timeStr}";
            } elseif ($baakRejected) {
                $baakInfo = "Ditolak oleh BAAK Fakultas";
            }

            $itemSteps[] = [
                'label' => $baakApproved ? 'Disetujui BAAK' : ($baakRejected ? 'Ditolak BAAK' : 'Verifikasi BAAK'),
                'done' => $baakDone,
                'icon' => $baakApproved ? 'check' : ($baakRejected ? 'xmark' : 'clock'),
                'color' => $baakApproved ? 'bg-emerald-500' : ($baakRejected ? 'bg-red-500' : 'bg-yellow-500'),
                'info' => $baakInfo,
                'note' => $baakRejected ? $tugasAkhir->keterangan : null,
            ];
        } else {
            $itemSteps[] = [
                'label' => 'Verifikasi BAAK', 'done' => false, 'icon' => 'clock', 'color' => 'bg-yellow-500',
                'info' => 'Belum diproses', 'note' => null,
            ];
        }

        $overallSteps = $this->progressService->getSteps($mahasiswa);

        return view('mahasiswa.tugas_akhir.edit', compact('mahasiswa', 'itemSteps', 'overallSteps', 'isLocked', 'readonly'));
    }

    public function updateTugasAkhir(StoreTugasAkhirRequest $request)
    {
        $user = Auth::user();
        if (!$user->id_mahasiswa) {
            abort(403);
        }

        $mahasiswaId = $user->id_mahasiswa;

        $mahasiswa = Mahasiswa::with(['tugasAkhir', 'pengajuanSkpi'])->find($mahasiswaId);

        if (!$mahasiswa) {
            abort(404, 'Data mahasiswa tidak ditemukan.');
        }

        $tugasAkhir = $mahasiswa->tugasAkhir;
        $pengajuan = $mahasiswa->pengajuanSkpi;

        $isRejected = $tugasAkhir && $tugasAkhir->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
        $isApproved = $tugasAkhir && $tugasAkhir->status === 'approved';

        if ($isLocked) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Tugas Akhir tidak dapat diubah karena pengajuan SKPI sedang diproses.');
        }

        if ($isApproved) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Data Tugas Akhir yang telah disetujui tidak dapat diubah.');
        }

        DB::transaction(function () use ($mahasiswa, $request, $mahasiswaId) {
            $tugasAkhir = TugasAkhir::updateOrCreate(
                ['id_mahasiswa' => $mahasiswaId],
                [
                    'judul' => $request->judul,
                    'status' => 'pending',
                    'approved_by' => null,
                    'approved_at' => null,
                    'keterangan' => null,
                ]
            );

            DB::table('pembimbing_tugas_akhir')
                ->where('id_tugas_akhir', $tugasAkhir->id_tugas_akhir)
                ->delete();

            $pembimbingNames = collect($request->pembimbing)
                ->filter(fn($name) => !empty(trim($name)))
                ->unique()
                ->values();

            foreach ($pembimbingNames as $index => $nameDosen) {
                DB::table('pembimbing_tugas_akhir')->insert([
                    'id_tugas_akhir' => $tugasAkhir->id_tugas_akhir,
                    'nama_dosen' => trim($nameDosen),
                    'urutan_pembimbing' => $index + 1,
                ]);
            }
        });

        $this->autoResubmitIfNeeded();

        $this->cache->flushDashboard($mahasiswaId);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Data Tugas Akhir berhasil diperbarui.');
    }
}
