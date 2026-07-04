<?php

namespace App\Providers;

use App\Services\ApprovalService;
use App\Services\CacheService;
use App\Services\SkpiService;
use App\Services\SkpiProgressService;
use App\Services\PengajuanService;
use App\Services\VerifikasiService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(CacheService::class);
        $this->app->singleton(SkpiProgressService::class);
        $this->app->singleton(PengajuanService::class);
        $this->app->singleton(VerifikasiService::class);
        $this->app->singleton(SkpiService::class);
        $this->app->singleton(ApprovalService::class);
    }

    public function boot(): void
    {
        //
    }
}
