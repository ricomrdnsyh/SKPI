<?php

namespace App\Services;

use App\Models\PengajuanSkpi;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class PengajuanService
{
    public function submitCetak($idMahasiswa, ?string $catatan): PengajuanSkpi
    {
        return DB::transaction(function () use ($idMahasiswa, $catatan) {
            return PengajuanSkpi::create([
                'id_mahasiswa' => $idMahasiswa,
                'status' => 'diajukan',
                'tanggal_pengajuan' => now(),
                'catatan_mahasiswa' => $catatan,
                'permohonan_cetak' => true,
            ]);
        });
    }

    public function hasTugasAkhir(Mahasiswa $mahasiswa): bool
    {
        return DB::table('tugas_akhir')
            ->where('id_mahasiswa', $mahasiswa->id_mahasiswa)
            ->whereNotNull('judul')
            ->where('judul', '!=', '')
            ->exists();
    }
}
