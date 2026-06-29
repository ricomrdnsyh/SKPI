<?php

namespace App\Http\Controllers\Traits;

use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AutoResubmitPengajuan
{
    protected function autoResubmitIfNeeded(): void
    {
        $id_mahasiswa = Auth::user()->id_mahasiswa;
        if (!$id_mahasiswa) return;

        $pengajuan = DB::table('pengajuan_skpi')
            ->where('id_mahasiswa', $id_mahasiswa)
            ->first();

        if (!$pengajuan) {
            return;
        }

        DB::transaction(function () use ($pengajuan) {
            if (in_array($pengajuan->status, ['ditolak', 'draft', 'verifikasi'])) {
                DB::table('pengajuan_skpi')
                    ->where('id_pengajuan', $pengajuan->id_pengajuan)
                    ->update([
                        'status' => 'diajukan',
                        'tanggal_pengajuan' => now(),
                        'diverifikasi_oleh' => null,
                        'tanggal_verifikasi' => null,
                        'catatan_bak' => null,
                    ]);

                DB::table('checklist_verifikasi_skpi')
                    ->where('id_pengajuan', $pengajuan->id_pengajuan)
                    ->delete();
            }
        });

        app(CacheService::class)->flushDashboard($id_mahasiswa);
    }
}
