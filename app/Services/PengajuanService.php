<?php

namespace App\Services;

use App\Models\PengajuanSkpi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class PengajuanService
{
    public function getStudentTahunAkademik($idMahasiswa)
    {
        try {
            // Ambil tahun akademik / semester kelulusan atau terakhir aktif dari SIMPT
            $simptData = DB::selectOne("
                SELECT
                    b.id_smt AS id_smt
                FROM dbsimpt.tbmas_mahasiswa_pt a
                LEFT JOIN dbsimpt.tbbak_kuliah_mahasiswa b 
                    ON a.id_mahasiswa_pt = b.id_mahasiswa_pt
                WHERE a.nipd = ? 
                  AND b.ipk_ketuntasan IS NOT NULL
                ORDER BY b.id_smt DESC
                LIMIT 1
            ", [$idMahasiswa]);

            if ($simptData && $simptData->id_smt) {
                $tahunAkademik = DB::table('tahun_akademik')
                    ->where('id_tahun_akademik', $simptData->id_smt)
                    ->first();
                
                if ($tahunAkademik) {
                    return $tahunAkademik;
                }
            }
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Gagal ambil tahun akademik SIMPT untuk NIM: {$idMahasiswa}", [
                'error' => $e->getMessage()
            ]);
        }

        // Fallback: gunakan tahun akademik yang sedang aktif jika data SIMPT tidak ditemukan
        return DB::table('tahun_akademik')->where('is_active', true)->first();
    }

    public function submitCetak($idMahasiswa, ?string $catatan): PengajuanSkpi
    {
        $activeTahun = $this->getStudentTahunAkademik($idMahasiswa);
        $universitas = DB::table('universitas')->first();
        $sistemPenilaian = DB::table('sistem_penilaian')->get();
        
        return DB::transaction(function () use ($idMahasiswa, $catatan, $activeTahun, $universitas, $sistemPenilaian) {
            return PengajuanSkpi::create([
                'nim' => $idMahasiswa,
                'status' => 'diajukan',
                'tanggal_pengajuan' => now(),
                'catatan_mahasiswa' => $catatan,
                'permohonan_cetak' => true,
                'id_tahun_akademik' => $activeTahun?->id_tahun_akademik,
                'sk_akreditasi' => $universitas?->sk_akreditasi,
                'sistem_penilaian' => $sistemPenilaian->toArray(),
                'tanggal_terbit_skpi' => $universitas?->tanggal_terbit_skpi,
            ]);
        });
    }

    public function hasTugasAkhir(Mahasiswa $mahasiswa): bool
    {
        return DB::table('tugas_akhir')
            ->where('nim', $mahasiswa->nim)
            ->whereNotNull('judul')
            ->where('judul', '!=', '')
            ->exists();
    }
}
