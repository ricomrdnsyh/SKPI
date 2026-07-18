<?php

namespace App\Http\Controllers\Traits;

use App\Services\CacheService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

trait AutoResubmitPengajuan
{
    protected function autoResubmitIfNeeded(): void
    {
        $nim = Auth::user()->nim;
        if (!$nim) return;

        $pengajuan = DB::table('pengajuan_skpi')
            ->where('nim', $nim)
            ->first();

        if (!$pengajuan) {
            return;
        }

        app(CacheService::class)->flushDashboard($nim);
    }
}
