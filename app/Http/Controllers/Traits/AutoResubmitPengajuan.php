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

        app(CacheService::class)->flushDashboard($id_mahasiswa);
    }
}
