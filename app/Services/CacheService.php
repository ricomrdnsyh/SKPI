<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class CacheService
{
    private const TTL_MASTER = 7200;
    private const TTL_CPL = 3600;
    private const TTL_DASHBOARD = 120;
    private const TTL_DETAIL = 60;
    private const TTL_STATS = 300;

    public function getProgramStudiById($id): ?object
    {
        if (!$id) return null;
        $all = $this->getAllProgramStudi();
        return $all->get($id);
    }

    public function getAllProgramStudi(): \Illuminate\Support\Collection
    {
        return Cache::remember('master:program_studi', self::TTL_MASTER, function () {
            return DB::table('program_studi')->get()->keyBy('id_prodi');
        });
    }

    public function getFakultasById($id): ?object
    {
        if (!$id) return null;
        $all = $this->getAllFakultas();
        return $all->get($id);
    }

    public function getAllFakultas(): \Illuminate\Support\Collection
    {
        return Cache::remember('master:fakultas', self::TTL_MASTER, function () {
            return DB::table('fakultas')->get()->keyBy('id_fakultas');
        });
    }

    public function getSistemPenilaian(): \Illuminate\Support\Collection
    {
        return Cache::remember('master:sistem_penilaian', self::TTL_MASTER, function () {
            return DB::table('sistem_penilaian')->orderBy('nilai_min')->get();
        });
    }

    public function getCplByProdiAndKurikulum($idProdi, $idKurikulum): \Illuminate\Support\Collection
    {
        $cacheKey = "cpl:prodi:{$idProdi}:kur:{$idKurikulum}";
        return Cache::remember($cacheKey, self::TTL_CPL, function () use ($idProdi, $idKurikulum) {
            $query = DB::table('cpl_prodi')
                ->join('kategori_cpl', 'cpl_prodi.id_kategori', '=', 'kategori_cpl.id_kategori')
                ->where('cpl_prodi.id_prodi', $idProdi)
                ->orderBy('kategori_cpl.urutan')
                ->orderBy('cpl_prodi.urutan')
                ->select(
                    'cpl_prodi.id_prodi',
                    'kategori_cpl.nama_kategori',
                    'kategori_cpl.kode_kategori',
                    'kategori_cpl.urutan as urutan_kategori',
                    'cpl_prodi.kode_cpl',
                    'cpl_prodi.deskripsi_cpl',
                    'cpl_prodi.urutan as urutan_cpl'
                );
            if ($idKurikulum) {
                $query->where('cpl_prodi.id_kurikulum', $idKurikulum);
            }
            return $query->get()->groupBy('nama_kategori');
        });
    }



    public function rememberDashboard(string $key, \Closure $callback): mixed
    {
        return Cache::remember("dashboard:{$key}", self::TTL_DASHBOARD, $callback);
    }

    public function rememberDetail(string $key, \Closure $callback): mixed
    {
        return Cache::remember("detail:{$key}", self::TTL_DETAIL, $callback);
    }

    public function rememberStats(string $key, \Closure $callback): mixed
    {
        return Cache::remember("stats:{$key}", self::TTL_STATS, $callback);
    }

    // ── Flush methods ──

    public function flushDashboard($mahasiswaId): void
    {
        Cache::forget("dashboard:mahasiswa:{$mahasiswaId}");
    }

    public function flushDetail($pengajuanId): void
    {
        Cache::forget("detail:verifikasi:{$pengajuanId}");
    }
}
