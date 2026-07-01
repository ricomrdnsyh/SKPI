<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTugasAkhirRequest;
use App\Models\Mahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\TugasAkhir;
use App\Services\CacheService;
use App\Services\DataPreloader;
use App\Services\SkpiProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Traits\AutoResubmitPengajuan;

class MahasiswaController extends Controller
{
    use AutoResubmitPengajuan;

    public function __construct(
        private SkpiProgressService $progressService,
        private CacheService $cache,
        private DataPreloader $preloader
    ) {}

    public function dashboard()
    {
        $user = Auth::user();
        if (!$user->id_mahasiswa) {
            abort(403, 'User tidak terhubung ke data mahasiswa.');
        }

        $mahasiswaId = $user->id_mahasiswa;

        return $this->cache->rememberDashboard("mahasiswa:{$mahasiswaId}", function () use ($mahasiswaId) {
            $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $mahasiswaId)->first();
            if (!$mahasiswaRow) {
                abort(404, 'Data mahasiswa tidak ditemukan.');
            }
            $mahasiswa = Mahasiswa::hydrate([(array) $mahasiswaRow])->first();

            $prodi = $this->preloader->getProdi($mahasiswa->id_prodi);
            if ($prodi) {
                $prodi->fakultas = $this->preloader->getFakultas($prodi->id_fakultas);
            }
            $mahasiswa->programStudi = $prodi;

            $prestasi = DB::table('prestasi_mahasiswa')
                ->where('id_mahasiswa', $mahasiswaId)
                ->select(['id_prestasi', 'nama_prestasi', 'tingkat', 'status', 'approved_by', 'approved_at', 'keterangan', 'file_bukti'])
                ->get();
            $mahasiswa->prestasi = $prestasi;

            $organisasi = DB::table('organisasi_mahasiswa')
                ->where('id_mahasiswa', $mahasiswaId)
                ->select(['id_organisasi_mhs', 'nama_organisasi', 'jabatan', 'status', 'approved_by', 'approved_at', 'keterangan', 'file_bukti'])
                ->get();
            $mahasiswa->organisasi = $organisasi;

            $sertifikat = DB::table('sertifikat_mahasiswa')
                ->where('id_mahasiswa', $mahasiswaId)
                ->select(['id_sertifikat', 'nama_sertifikat', 'penyelenggara', 'status', 'approved_by', 'approved_at', 'keterangan', 'file_bukti'])
                ->get();
            $mahasiswa->sertifikat = $sertifikat;

            $magangCollection = DB::table('magang_mahasiswa')
                ->where('magang_mahasiswa.id_mahasiswa', $mahasiswaId)
                ->select('magang_mahasiswa.*')
                ->get();

            $magang = $magangCollection->map(function ($item) {
                $item->tempatMagang = (object) [
                    'nama_perusahaan' => $item->tempat_magang ?? '',
                    'alamat' => '',
                ];
                return $item;
            });
            $mahasiswa->magang = $magang;

            $taRaw = DB::table('tugas_akhir')
                ->where('id_mahasiswa', $mahasiswaId)
                ->first();

            $tugasAkhir = null;
            if ($taRaw) {
                $pembimbingCollection = DB::table('pembimbing_tugas_akhir')
                    ->where('id_tugas_akhir', $taRaw->id_tugas_akhir)
                    ->orderBy('urutan_pembimbing')
                    ->get();

                $tugasAkhir = (object) [
                    'id_tugas_akhir' => $taRaw->id_tugas_akhir,
                    'judul' => $taRaw->judul,
                    'status' => $taRaw->status,
                    'approved_by' => $taRaw->approved_by,
                    'approved_at' => $taRaw->approved_at,
                    'keterangan' => $taRaw->keterangan,
                    'pembimbingTugasAkhir' => $pembimbingCollection,
                ];
            }
            $mahasiswa->tugasAkhir = $tugasAkhir;

            $skpi = DB::table('skpi')
                ->where('id_mahasiswa', $mahasiswaId)
                ->first();

            if ($skpi && $skpi->dicetak_oleh) {
                $skpi->printer = $this->preloader->getUser($skpi->dicetak_oleh);
            }
            $mahasiswa->skpi = $skpi;

            $pengajuanRow = DB::table('pengajuan_skpi')->where('id_mahasiswa', $mahasiswaId)->first();
            $pengajuan = $pengajuanRow ? PengajuanSkpi::hydrate([(array) $pengajuanRow])->first() : null;

            if ($pengajuan) {
                $pengajuan->verifier = $pengajuan->diverifikasi_oleh
                    ? $this->preloader->getUser($pengajuan->diverifikasi_oleh)
                    : null;
                $pengajuan->checklist = null;

                if ($skpi) {
                    $pengajuan->skpi = $skpi;
                }
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

        $taRaw = DB::table('tugas_akhir')
            ->where('id_mahasiswa', $mahasiswaId)
            ->first();

        $pengajuan = DB::table('pengajuan_skpi')
            ->where('id_mahasiswa', $mahasiswaId)
            ->first();

        $isRejected = $taRaw && $taRaw->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
        $isApproved = $taRaw && $taRaw->status === 'approved';
        $readonly = $isLocked || $isApproved;

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $mahasiswaId)->first();
        if (!$mahasiswaRow) {
            abort(404, 'Data mahasiswa tidak ditemukan.');
        }
        $mahasiswa = Mahasiswa::hydrate([(array) $mahasiswaRow])->first();

        $tugasAkhir = null;
        if ($taRaw) {
            $pembimbingCollection = DB::table('pembimbing_tugas_akhir')
                ->where('id_tugas_akhir', $taRaw->id_tugas_akhir)
                ->orderBy('urutan_pembimbing')
                ->get();

            $tugasAkhir = (object) [
                'id_tugas_akhir' => $taRaw->id_tugas_akhir,
                'judul' => $taRaw->judul,
                'status' => $taRaw->status,
                'approved_by' => $taRaw->approved_by,
                'keterangan' => $taRaw->keterangan,
                'pembimbingTugasAkhir' => $pembimbingCollection,
            ];
        }
        $mahasiswa->tugasAkhir = $tugasAkhir;

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

        $taRaw = DB::table('tugas_akhir')
            ->where('id_mahasiswa', $mahasiswaId)
            ->first();

        $pengajuan = DB::table('pengajuan_skpi')
            ->where('id_mahasiswa', $mahasiswaId)
            ->first();

        $isRejected = $taRaw && $taRaw->status === 'rejected';
        $isLocked = !$isRejected && $pengajuan && in_array($pengajuan->status, ['diajukan', 'verifikasi', 'dicetak']);
        $isApproved = $taRaw && $taRaw->status === 'approved';

        if ($isLocked) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Tugas Akhir tidak dapat diubah karena pengajuan SKPI sedang diproses.');
        }

        if ($isApproved) {
            return redirect()->route('mahasiswa.dashboard')->with('error', 'Data Tugas Akhir yang telah disetujui tidak dapat diubah.');
        }

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $mahasiswaId)->first();
        if (!$mahasiswaRow) {
            abort(404, 'Data mahasiswa tidak ditemukan.');
        }
        $mahasiswa = Mahasiswa::hydrate([(array) $mahasiswaRow])->first();

        DB::transaction(function () use ($mahasiswa, $request, $taRaw, $mahasiswaId) {
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
