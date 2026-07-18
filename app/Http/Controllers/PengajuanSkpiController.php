<?php

namespace App\Http\Controllers;

use App\Http\Requests\PengajuanSkpiRequest;
use App\Models\Mahasiswa;
use App\Services\CacheService;
use App\Services\PengajuanService;
use App\Services\SkpiProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanSkpiController extends Controller
{
    public function __construct(
        private PengajuanService $pengajuanService,
        private SkpiProgressService $progressService,
        private CacheService $cache
    ) {}

    public function submit(PengajuanSkpiRequest $request)
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        if (!$id_mahasiswa) {
            abort(403, 'Akses ditolak.');
        }

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->first();
        if (!$mahasiswaRow) abort(404);
        $mahasiswa = Mahasiswa::hydrate([(array) $mahasiswaRow])->first();

        if (!$this->pengajuanService->hasTugasAkhir($mahasiswa)) {
            return back()->with('error', 'Anda belum mengisi data Tugas Akhir. Tugas Akhir wajib diisi sebelum mengajukan SKPI.');
        }

        $existing = DB::table('pengajuan_skpi')
            ->where('id_mahasiswa', $id_mahasiswa)
            ->first();

        if ($existing) {
            if ($existing->status === 'dicetak') {
                return back()->with('error', 'SKPI sudah diterbitkan.');
            }
            if (in_array($existing->status, ['diajukan', 'verifikasi'])) {
                return back()->with('error', 'Anda sudah memiliki pengajuan cetak SKPI yang sedang diproses.');
            }
            if (in_array($existing->status, ['ditolak', 'draft'])) {
                DB::transaction(function () use ($existing, $request, $id_mahasiswa) {
                    $activeTahun = DB::table('tahun_akademik')->where('is_active', true)->first();
                    
                    DB::table('pengajuan_skpi')
                        ->where('id_pengajuan', $existing->id_pengajuan)
                        ->update([
                            'status' => 'diajukan',
                            'tanggal_pengajuan' => now(),
                            'catatan_mahasiswa' => $request->catatan_mahasiswa,
                            'diverifikasi_oleh' => null,
                            'tanggal_verifikasi' => null,
                            'catatan_bak' => null,
                            'id_tahun_akademik' => $activeTahun?->id_tahun_akademik,
                        ]);

                    DB::table('checklist_verifikasi_skpi')
                        ->where('id_pengajuan', $existing->id_pengajuan)
                        ->delete();
                });

                $this->cache->flushDashboard($id_mahasiswa);

                return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan cetak SKPI berhasil diajukan ulang.');
            }
        }

        try {
            $this->pengajuanService->submitCetak($id_mahasiswa, $request->catatan_mahasiswa);
        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }

        $this->cache->flushDashboard($id_mahasiswa);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Pengajuan cetak SKPI berhasil diajukan dan sedang menunggu proses verifikasi.');
    }

    public function requestPrint(Request $request)
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        if (!$id_mahasiswa) {
            abort(403, 'Akses ditolak.');
        }

        $pengajuan = DB::table('pengajuan_skpi')
            ->where('id_mahasiswa', $id_mahasiswa)
            ->firstOrFail();

        if ($pengajuan->status !== 'verifikasi') {
            return back()->with('error', 'Permohonan cetak hanya dapat diajukan jika pengajuan SKPI Anda sudah masuk tahap verifikasi.');
        }

        $mahasiswaRow = DB::table('mahasiswa')->where('id_mahasiswa', $id_mahasiswa)->first();
        if (!$mahasiswaRow) abort(404);
        $mahasiswa = Mahasiswa::hydrate([(array) $mahasiswaRow])->first();
        if (!$mahasiswa->tugasAkhirApproved()) {
            return back()->with('error', 'Permohonan cetak ditangguhkan karena Tugas Akhir belum disetujui.');
        }

        DB::table('pengajuan_skpi')
            ->where('id_pengajuan', $pengajuan->id_pengajuan)
            ->update(['permohonan_cetak' => true]);

        $this->cache->flushDashboard($id_mahasiswa);

        return redirect()->route('mahasiswa.dashboard')->with('success', 'Permohonan cetak SKPI berhasil diajukan ke BAAK Fakultas.');
    }
}
