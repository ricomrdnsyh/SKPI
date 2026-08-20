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
