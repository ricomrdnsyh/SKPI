<?php

namespace App\Services;

use App\Models\PengajuanSkpi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class PengajuanService
{
    public function submitCetak($idMahasiswa, ?string $catatan): PengajuanSkpi
    {
        $activeTahun = DB::table('tahun_akademik')->where('is_active', true)->first();
        
        return DB::transaction(function () use ($idMahasiswa, $catatan, $activeTahun) {
            return PengajuanSkpi::create([
                'nim' => $idMahasiswa,
                'status' => 'diajukan',
                'tanggal_pengajuan' => now(),
                'catatan_mahasiswa' => $catatan,
                'permohonan_cetak' => true,
                'id_tahun_akademik' => $activeTahun?->id_tahun_akademik,
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
