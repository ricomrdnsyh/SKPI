<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\PrestasiMahasiswa;
use App\Models\OrganisasiMahasiswa;
use App\Models\SertifikatMahasiswa;
use App\Models\MagangMahasiswa;
use App\Http\Controllers\Traits\FilterByProdi;
use App\Http\Requests\RejectItemRequest;
use App\Helpers\DataTableHelper;
use App\Services\ApprovalService;
use App\Services\CacheService;
use App\Services\SkpiProgressService;
use App\Services\PengajuanService;
use App\Services\SkpiService;
use App\Services\VerifikasiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class VerifikasiController extends Controller
{
    use FilterByProdi;

    public function __construct(
        private VerifikasiService $verifikasiService,
        private SkpiProgressService $progressService,
        private PengajuanService $pengajuanService,
        private SkpiService $skpiService,
        private ApprovalService $approvalService,
        private CacheService $cache
    ) {}

    public function dashboard()
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $statusCounts = $this->cache->rememberStats('bak:' . ($user->id_user ?? 'guest'), function () use ($allowedProdis) {
            $query = DB::table('pengajuan_skpi')
                ->leftJoin('mahasiswa', 'pengajuan_skpi.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa');

            if ($allowedProdis !== null) {
                $query->whereIn('mahasiswa.id_prodi', $allowedProdis);
            }

            return (clone $query)
                ->selectRaw('COALESCE(pengajuan_skpi.status, "unknown") as status, COUNT(*) as count')
                ->groupBy('pengajuan_skpi.status')
                ->pluck('count', 'status');
        });

        $cacheKey = $allowedProdis !== null
            ? 'permohonan_cetak:' . md5(implode(',', $allowedProdis))
            : 'permohonan_cetak:all';

        $permohonanCetakCount = $this->cache->rememberStats($cacheKey, function () use ($allowedProdis) {
            $query = DB::table('pengajuan_skpi')
                ->where('status', 'verifikasi')
                ->where('permohonan_cetak', true);

            if ($allowedProdis !== null) {
                $query->whereIn('id_mahasiswa', function ($q) use ($allowedProdis) {
                    $q->select('id_mahasiswa')->from('mahasiswa')->whereIn('id_prodi', $allowedProdis);
                });
            }

            return $query->count();
        });

        $pendingCountQuery = PengajuanSkpi::query()
            ->leftJoin('mahasiswa', 'pengajuan_skpi.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa');
        if ($allowedProdis !== null) {
            $pendingCountQuery->whereIn('mahasiswa.id_prodi', $allowedProdis);
        }
        $pendingCount = $pendingCountQuery->hasPendingItems()->count();

        $stats = [
            'pending' => $pendingCount,
            'verifikasi' => $statusCounts->get('verifikasi', 0),
            'completed' => $statusCounts->get('dicetak', 0),
            'sudah_verifikasi' => $statusCounts->only(['verifikasi', 'dicetak', 'ditolak'])->sum(),
            'permohonan_cetak_count' => $permohonanCetakCount,
        ];

        $statuses = $this->getStatusesCached();
        $prodis = $this->getProdiListCached($allowedProdis);

        return view('bak_fakultas.dashboard.index', compact('stats', 'statuses', 'prodis'));
    }

    private function getStatusesCached(): \Illuminate\Support\Collection
    {
        return Cache::remember('master:pengajuan_statuses', 7200, function () {
            return DB::table('pengajuan_skpi')
                ->select('status')->distinct()
                ->pluck('status')->sort()->values();
        });
    }

    private function getProdiListCached($allowedProdis = null): \Illuminate\Support\Collection
    {
        $cacheKey = 'master:prodi_names' . ($allowedProdis ? ':' . md5(implode(',', $allowedProdis)) : ':all');
        return Cache::remember($cacheKey, 7200, function () use ($allowedProdis) {
            return DB::table('program_studi')
                ->when($allowedProdis, fn($q) => $q->whereIn('id_prodi', $allowedProdis))
                ->pluck('nama_prodi')->sort()->values();
        });
    }

    public function detail(int $id_pengajuan)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $pengajuanRow = DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        $pengajuan = PengajuanSkpi::hydrate([(array) $pengajuanRow])->first();

        $mahasiswa = Mahasiswa::with([
            'programStudi',
            'prestasi',
            'organisasi',
            'sertifikat',
            'magang',
            'tugasAkhir.pembimbing',
            'skpi'
        ])->find($pengajuan->id_mahasiswa);

        if (!$mahasiswa) {
            abort(404, 'Mahasiswa tidak ditemukan.');
        }

        $prodi = $mahasiswa->programStudi;
        if ($prodi) {
            $prodi->cpl = $this->cache->getCplByProdiAndKurikulum($prodi->id_prodi, $mahasiswa->id_kurikulum);
            $prodi->sistemPenilaian = $this->cache->getSistemPenilaian();
        }

        $pengajuan->skpi = $mahasiswa->skpi;
        $pengajuan->checklist = DB::table('checklist_verifikasi_skpi')->where('id_pengajuan', $pengajuan->id_pengajuan)->first();

        if ($allowedProdis !== null && !in_array($mahasiswa->id_prodi, $allowedProdis)) {
            abort(403, 'Akses ditolak. Mahasiswa ini berada di luar Program Studi/Fakultas Anda.');
        }

        $cached = $this->cache->rememberDetail("verifikasi:{$id_pengajuan}", function () use ($mahasiswa, $pengajuan) {
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

            $tugasAkhir = $mahasiswa->tugasAkhir;
            if ($tugasAkhir) {
                $tugasAkhir->pembimbingTugasAkhir = $tugasAkhir->pembimbing;
            }

            $history = $this->verifikasiService->getHistoryTimeline($pengajuan);

            $hasPendingItems = $prestasi->where('status', 'pending')->isNotEmpty()
                || $organisasi->where('status', 'pending')->isNotEmpty()
                || $sertifikat->where('status', 'pending')->isNotEmpty()
                || $magang->where('status', 'pending')->isNotEmpty()
                || ($tugasAkhir && $tugasAkhir->status === 'pending');
            $hasNoTugasAkhir = !$tugasAkhir || !$tugasAkhir->judul;

            return compact('mahasiswa', 'prestasi', 'organisasi', 'sertifikat', 'magang', 'history', 'hasPendingItems', 'hasNoTugasAkhir');
        });

        return view('bak_fakultas.verifikasi.detail', array_merge($cached, compact('pengajuan')));
    }

    private function flushRelatedCaches(int $pengajuanId, int $mahasiswaId): void
    {
        if (!$pengajuanId && $mahasiswaId) {
            $pengajuanId = DB::table('pengajuan_skpi')->where('id_mahasiswa', $mahasiswaId)->value('id_pengajuan') ?? 0;
        }
        $this->cache->flushDetail($pengajuanId);
        $this->cache->flushDashboard($mahasiswaId);
        Cache::forget('master:pengajuan_statuses');
    }

    public function cancelPrint(int $id_pengajuan, Request $request)
    {
        $request->validate([
            'catatan' => 'required|string|max:1000'
        ]);

        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $pengajuanRow = DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        if ($pengajuanRow->status !== 'dicetak') {
            return back()->with('error', 'Pengajuan belum dicetak.');
        }

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $pengajuanRow->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        DB::transaction(function () use ($id_pengajuan, $pengajuanRow, $request, $user) {
            DB::table('skpi')->where('id_pengajuan', $id_pengajuan)->delete();

            DB::table('checklist_verifikasi_skpi')->where('id_pengajuan', $id_pengajuan)->update([
                'hasil_verifikasi' => 'perlu_revisi',
                'catatan' => $request->catatan,
                'diverifikasi_oleh' => $user->id_user,
                'tanggal_verifikasi' => now(),
            ]);

            DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->update([
                'status' => 'draft',
                'catatan_bak' => $request->catatan,
                'permohonan_cetak' => false,
                'diverifikasi_oleh' => null,
                'tanggal_verifikasi' => null,
            ]);

            \App\Models\Approval::create([
                'approvable_type' => 'pengajuan_skpi',
                'approvable_id' => $id_pengajuan,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'rejected',
                'notes' => 'Pembatalan Cetak: ' . $request->catatan,
            ]);
        });

        $this->flushRelatedCaches($id_pengajuan, $pengajuanRow->id_mahasiswa);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Pencetakan SKPI berhasil dibatalkan. Status dikembalikan ke Draft agar mahasiswa dapat mengedit.'
            ]);
        }

        return redirect()->route('bak_fakultas.dashboard')
            ->with('success', 'Pencetakan SKPI berhasil dibatalkan. Status dikembalikan ke Draft agar mahasiswa dapat mengedit.');
    }


    public function approveItem(string $type, int $id)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $item = $this->resolveItem($type, $id);

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $item->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        try {
            $this->approvalService->baakApproveGrupA($type, $id, $user);
            $this->flushRelatedCaches($item->id_pengajuan ?? 0, $item->id_mahasiswa);
            return back()->with('success', 'Data ' . $type . ' berhasil disetujui.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function rejectItem(RejectItemRequest $request, string $type, int $id)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $item = $this->resolveItem($type, $id);

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $item->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        try {
            $this->approvalService->baakRejectGrupA($type, $id, $request->keterangan, $user);
            $this->flushRelatedCaches($item->id_pengajuan ?? 0, $item->id_mahasiswa);
            return back()->with('success', 'Data ' . $type . ' berhasil ditolak.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function approveTugasAkhir(int $id)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $itemRow = DB::table('tugas_akhir')->where('id_tugas_akhir', $id)->first();
        if (!$itemRow) abort(404);
        $item = \App\Models\TugasAkhir::hydrate([(array) $itemRow])->first();

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $item->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        try {
            $this->approvalService->baakApproveTugasAkhir($id, $user);
            $this->flushRelatedCaches(0, $item->id_mahasiswa);
            return back()->with('success', 'Tugas Akhir berhasil disetujui.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function rejectTugasAkhir(RejectItemRequest $request, int $id)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $itemRow = DB::table('tugas_akhir')->where('id_tugas_akhir', $id)->first();
        if (!$itemRow) abort(404);
        $item = \App\Models\TugasAkhir::hydrate([(array) $itemRow])->first();

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $item->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        try {
            $this->approvalService->baakRejectTugasAkhir($id, $request->keterangan, $user);
            $this->flushRelatedCaches(0, $item->id_mahasiswa);
            return back()->with('success', 'Tugas Akhir berhasil ditolak.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function approvePengajuanCetak(int $id_pengajuan)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $pengajuanRow = DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        $pengajuan = PengajuanSkpi::hydrate([(array) $pengajuanRow])->first();

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $pengajuan->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        try {
            $this->approvalService->baakApprovePengajuanCetak($id_pengajuan, $user);
            $this->flushRelatedCaches($id_pengajuan, $pengajuan->id_mahasiswa);
            return back()->with('success', 'Pengajuan cetak berhasil disetujui.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function rejectPengajuanCetak(RejectItemRequest $request, int $id_pengajuan)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $pengajuanRow = DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        $pengajuan = PengajuanSkpi::hydrate([(array) $pengajuanRow])->first();

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $pengajuan->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        try {
            $this->approvalService->baakRejectPengajuanCetak($id_pengajuan, $request->keterangan, $user);
            $this->flushRelatedCaches($id_pengajuan, $pengajuan->id_mahasiswa);
            return back()->with('error', 'Pengajuan cetak berhasil ditolak.');
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    private function resolveItem(string $type, int $id): object
    {
        $table = match ($type) {
            'prestasi' => 'prestasi_mahasiswa',
            'organisasi' => 'organisasi_mahasiswa',
            'sertifikat' => 'sertifikat_mahasiswa',
            'magang' => 'magang_mahasiswa',
            default => abort(404, 'Kategori tidak valid.'),
        };
        $primaryKey = match ($type) {
            'prestasi' => 'id_prestasi',
            'organisasi' => 'id_organisasi_mhs',
            'sertifikat' => 'id_sertifikat',
            'magang' => 'id_magang',
        };
        $item = DB::table($table)->where($primaryKey, $id)->first();
        if (!$item) abort(404, 'Data tidak ditemukan.');
        return $item;
    }

    public function publish(Request $request, int $id_pengajuan)
    {
        $pengajuanRow = DB::table('pengajuan_skpi')
            ->select(['id_pengajuan', 'id_mahasiswa', 'status', 'permohonan_cetak', 'diverifikasi_oleh'])
            ->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        $pengajuan = PengajuanSkpi::hydrate([(array) $pengajuanRow])->first();
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $mahasiswaRow = DB::table('mahasiswa')
            ->select(['id_mahasiswa', 'id_prodi', 'id_kurikulum', 'nim', 'nama_lengkap', 'ipk', 'tahun_masuk', 'tahun_lulus', 'tanggal_lulus', 'status'])
            ->where('id_mahasiswa', $pengajuan->id_mahasiswa)->first();
        $mahasiswa = $mahasiswaRow ? Mahasiswa::hydrate([(array) $mahasiswaRow])->first() : null;
        if (!$mahasiswa) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($mahasiswa->id_prodi, $allowedProdis)) abort(403, 'Akses ditolak.');

        $skpi = DB::table('skpi')->where('id_pengajuan', $pengajuan->id_pengajuan)->first();
        if ($pengajuan->status === 'dicetak' || $skpi) {
            return back()->with('error', 'SKPI sudah diterbitkan sebelumnya.');
        }

        if (!$mahasiswa->tugasAkhirApproved()) {
            return back()->with('error', 'SKPI tidak dapat diterbitkan karena Tugas Akhir belum disetujui.');
        }

        $request->validate([
            'nim_ijazah' => 'required|string|max:50',
            'status_profesi' => 'nullable|string|max:255',
        ]);

        $error = $this->skpiService->checkNomorIjazahUnique($request->nim_ijazah);
        if ($error) return back()->with('error', $error);

        DB::transaction(function () use ($pengajuan, $request, $user) {
            $this->skpiService->createSkpi($pengajuan, $request->nim_ijazah, $request->status_profesi, $user);
            $pengajuan->update(['status' => 'dicetak']);
        });

        $this->flushRelatedCaches($id_pengajuan, $pengajuan->id_mahasiswa);

        return redirect()->route('bak_fakultas.verifikasi.detail', $pengajuan->id_pengajuan)
            ->with('success', 'SKPI berhasil diterbitkan.');
    }

    public function submitChecklist(Request $request, int $id_pengajuan)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);
        $pengajuanRow = DB::table('pengajuan_skpi')->where('id_pengajuan', $id_pengajuan)->first();
        if (!$pengajuanRow) abort(404);
        $pengajuan = PengajuanSkpi::hydrate([(array) $pengajuanRow])->first();

        $idProdi = DB::table('mahasiswa')->where('id_mahasiswa', $pengajuan->id_mahasiswa)->value('id_prodi');
        if (!$idProdi) abort(404, 'Mahasiswa tidak ditemukan.');
        if ($allowedProdis !== null && !in_array($idProdi, $allowedProdis)) abort(403, 'Akses ditolak.');

        $request->validate([
            'hasil_verifikasi' => 'required|in:lulus,perlu_revisi,ditolak',
            'catatan' => 'nullable|string|max:500',
        ]);

        $this->verifikasiService->submitChecklist($pengajuan, $request->only(['hasil_verifikasi', 'catatan']), $user);

        $this->flushRelatedCaches($id_pengajuan, $pengajuan->id_mahasiswa);

        return redirect()->route('bak_fakultas.verifikasi.detail', $pengajuan->id_pengajuan)
            ->with('success', 'Checklist verifikasi berhasil disimpan.');
    }

    public function datatable(Request $request)
    {
        $user = Auth::user();
        $allowedProdis = $this->getAllowedProdiIds($user);

        $query = DB::table('pengajuan_skpi')
            ->leftJoin('mahasiswa', 'pengajuan_skpi.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa')
            ->leftJoin('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
            ->leftJoin('checklist_verifikasi_skpi', 'pengajuan_skpi.id_pengajuan', '=', 'checklist_verifikasi_skpi.id_pengajuan')
            ->leftJoin('skpi', 'pengajuan_skpi.id_pengajuan', '=', 'skpi.id_pengajuan')
            ->select(
                'pengajuan_skpi.id_pengajuan',
                'pengajuan_skpi.id_mahasiswa',
                'pengajuan_skpi.status',
                'pengajuan_skpi.diverifikasi_oleh',
                'pengajuan_skpi.tanggal_pengajuan',
                'pengajuan_skpi.tanggal_verifikasi',
                'pengajuan_skpi.permohonan_cetak',
                'pengajuan_skpi.catatan_mahasiswa',
                'pengajuan_skpi.catatan_bak',
                'mahasiswa.nama_lengkap as mhs_nama',
                'mahasiswa.nim as mhs_nim',
                'mahasiswa.id_prodi as mhs_id_prodi',
                'program_studi.nama_prodi as prodi_nama',
                'checklist_verifikasi_skpi.cek_identitas_mahasiswa',
                'checklist_verifikasi_skpi.cek_identitas_prodi',
                'checklist_verifikasi_skpi.cek_cpl',
                'checklist_verifikasi_skpi.cek_prestasi',
                'checklist_verifikasi_skpi.cek_organisasi',
                'checklist_verifikasi_skpi.cek_sertifikat',
                'checklist_verifikasi_skpi.cek_magang',
                'checklist_verifikasi_skpi.cek_tugas_akhir',
                'checklist_verifikasi_skpi.cek_sistem_penilaian'
            );

        if ($allowedProdis !== null) {
            $query->whereIn('mahasiswa.id_prodi', $allowedProdis);
        }

        $tab = $request->tab;
        if ($tab === 'belum' || $tab === 'bypass') {
            $query = PengajuanSkpi::query()
                ->leftJoin('mahasiswa', 'pengajuan_skpi.id_mahasiswa', '=', 'mahasiswa.id_mahasiswa')
                ->leftJoin('program_studi', 'mahasiswa.id_prodi', '=', 'program_studi.id_prodi')
                ->leftJoin('checklist_verifikasi_skpi', 'pengajuan_skpi.id_pengajuan', '=', 'checklist_verifikasi_skpi.id_pengajuan')
                ->leftJoin('skpi', 'pengajuan_skpi.id_pengajuan', '=', 'skpi.id_pengajuan')
                ->select(
                    'pengajuan_skpi.id_pengajuan',
                    'pengajuan_skpi.id_mahasiswa',
                    'pengajuan_skpi.status',
                    'pengajuan_skpi.diverifikasi_oleh',
                    'pengajuan_skpi.tanggal_pengajuan',
                    'pengajuan_skpi.tanggal_verifikasi',
                    'pengajuan_skpi.permohonan_cetak',
                    'pengajuan_skpi.catatan_mahasiswa',
                    'pengajuan_skpi.catatan_bak',
                    'mahasiswa.nama_lengkap as mhs_nama',
                    'mahasiswa.nim as mhs_nim',
                    'mahasiswa.id_prodi as mhs_id_prodi',
                    'program_studi.nama_prodi as prodi_nama',
                    'checklist_verifikasi_skpi.cek_identitas_mahasiswa',
                    'checklist_verifikasi_skpi.cek_identitas_prodi',
                    'checklist_verifikasi_skpi.cek_cpl',
                    'checklist_verifikasi_skpi.cek_prestasi',
                    'checklist_verifikasi_skpi.cek_organisasi',
                    'checklist_verifikasi_skpi.cek_sertifikat',
                    'checklist_verifikasi_skpi.cek_magang',
                    'checklist_verifikasi_skpi.cek_tugas_akhir',
                    'checklist_verifikasi_skpi.cek_sistem_penilaian'
                );

            if ($allowedProdis !== null) {
                $query->whereIn('mahasiswa.id_prodi', $allowedProdis);
            }

            $query->hasPendingItems();
        } elseif ($tab === 'permohonan_cetak') {
            $query->where('pengajuan_skpi.status', 'verifikasi')
                ->where('pengajuan_skpi.permohonan_cetak', true);
        } elseif ($tab === 'sudah') {
            $query->whereIn('pengajuan_skpi.status', ['verifikasi', 'dicetak', 'ditolak']);
        }

        if ($request->filled('prodi')) {
            $query->where('program_studi.nama_prodi', $request->prodi);
        }
        if ($request->filled('status')) {
            $query->where('pengajuan_skpi.status', $request->status);
        }

        $studentIds = (clone $query)->pluck('pengajuan_skpi.id_mahasiswa')->unique()->toArray();
        $mahasiswas = collect();
        if (!empty($studentIds)) {
            $mahasiswas = Mahasiswa::with(['prestasi', 'organisasi', 'sertifikat', 'magang', 'tugasAkhir'])
                ->whereIn('id_mahasiswa', $studentIds)
                ->get()
                ->keyBy('id_mahasiswa');
        }

        return DataTables::of($query)
            ->filterColumn('mahasiswa', function($query, $keyword) {
                $query->where('mahasiswa.nama_lengkap', 'like', "%{$keyword}%");
            })
            ->filterColumn('nim', function($query, $keyword) {
                $query->where('mahasiswa.nim', 'like', "%{$keyword}%");
            })
            ->filterColumn('prodi', function($query, $keyword) {
                $query->where('program_studi.nama_prodi', 'like', "%{$keyword}%");
            })
            ->addColumn('mahasiswa', fn($p) => $p->mhs_nama ?? '-')
            ->addColumn('nim', fn($p) => $p->mhs_nim ?? '-')
            ->addColumn('prodi', fn($p) => $p->prodi_nama ?? '-')
            ->addColumn('dosen_wali', fn($p) => '-')
            ->addColumn('tanggal', fn($p) => DataTableHelper::tanggal($p->tanggal_pengajuan))
            ->addColumn('verifikasi', function ($p) use ($mahasiswas) {
                $mhs = $mahasiswas->get($p->id_mahasiswa);
                if (!$mhs) return '-';
                
                $mhs->loadMissing(['prestasi', 'organisasi', 'sertifikat', 'magang', 'tugasAkhir']);
                $allItems = collect()
                    ->concat($mhs->prestasi)
                    ->concat($mhs->organisasi)
                    ->concat($mhs->sertifikat)
                    ->concat($mhs->magang);
                
                if ($mhs->tugasAkhir) {
                    $allItems->push($mhs->tugasAkhir);
                }
                    
                $total = $allItems->count();
                if ($total == 0) return '<span class="badge badge-light-secondary fw-bold px-3 py-2">0 / 0</span>';

                if (in_array($p->status, ['dicetak', 'selesai', 'permohonan_cetak'])) {
                    $checked = $total;
                } else {
                    $checked = $allItems->where('status', 'approved')->count();
                }

                $color = ($checked == $total) ? 'success' : 'warning';
                if ($checked == 0 && $total > 0) $color = 'danger';

                return '<span class="badge badge-light-'.$color.' fw-bold px-3 py-2">'.$checked.' / '.$total.'</span>';
            })
            ->addColumn('progress', function ($p) use ($mahasiswas) {
                $mhs = $mahasiswas->get($p->id_mahasiswa);
                if (!$mhs) return DataTableHelper::progressBar(0);
                $steps = $this->progressService->getSteps($mhs, $p);
                $completed = collect($steps)->where('status', 'sudah')->count();
                return DataTableHelper::progressBar($completed);
            })
            ->addColumn('status', fn($p) => DataTableHelper::statusBadge($p->status))
            ->addColumn('aksi', function ($p) {
                $detailRoute = route('bak_fakultas.verifikasi.detail', $p->id_pengajuan);
                if ($p->status !== 'dicetak') {
                    return DataTableHelper::actionButtons([
                        ['type' => 'view', 'url' => $detailRoute],
                    ]);
                }

                $cancelRoute = route('bak_fakultas.verifikasi.cancel_print', $p->id_pengajuan);
                $csrfToken = csrf_token();
                return DataTableHelper::actionButtons([
                    ['type' => 'view', 'url' => $detailRoute],
                    ['type' => 'custom', 'html' => <<<HTML
<button type="button" class="btn btn-sm btn-light btn-active-light-danger border-0" data-bs-toggle="tooltip" data-bs-title="Batalkan Cetak SKPI" onclick="
    Swal.fire({
        icon: 'warning',
        iconColor: '#f1416c',
        title: 'Batalkan Cetak SKPI?',
        html: `
            <div class='text-gray-500 fw-semibold fs-6 mb-5'>
                Dokumen SKPI ini akan dibatalkan pencetakannya dan status dikembalikan ke tahap awal.
            </div>
            <div class='text-start'>
                <label class='required form-label fw-bold mb-2'>Alasan Pembatalan</label>
                <textarea id='cancel_reason' class='form-control' rows='4' placeholder='Ketik alasan pembatalan di sini...'></textarea>
            </div>
        `,
        width: '600px',
        showCancelButton: true,
        buttonsStyling: false,
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Tutup',
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        },
        preConfirm: () => {
            let reason = document.getElementById('cancel_reason').value;
            if (!reason || reason.trim() === '') {
                Swal.showValidationMessage('Alasan pembatalan cetak wajib diisi.');
                return false;
            }
            
            Swal.showLoading();
            
            return fetch('{$cancelRoute}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{$csrfToken}'
                },
                body: JSON.stringify({ catatan: reason })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(response.statusText || 'Terjadi kesalahan');
                }
                return response.json();
            })
            .catch(error => {
                Swal.showValidationMessage(`Gagal memproses permintaan: \${error}`);
            });
        }
    }).then((result) => {
        if (result.isConfirmed && result.value && result.value.success) {
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: result.value.message,
                confirmButtonText: 'Tutup',
                customClass: {
                    confirmButton: 'btn btn-primary'
                }
            }).then(() => {
                if (typeof $ !== 'undefined' && $.fn.DataTable.isDataTable('#table-bak-fakultas')) {
                    $('#table-bak-fakultas').DataTable().ajax.reload(null, false);
                } else {
                    window.location.reload();
                }
            });
        }
    });
">
    <i class="fa-solid fa-ban"></i>
</button>
HTML
                    ],
                ]);
            })
            ->rawColumns(['status', 'aksi', 'progress', 'verifikasi'])
            ->make(true);
    }
}
