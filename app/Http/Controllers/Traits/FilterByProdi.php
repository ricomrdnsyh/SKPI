<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait FilterByProdi
{
    private function getFakultasIdFromUser($user): ?int
    {
        $cacheKey = "user:fakultas_id:{$user->id_user}";
        return Cache::remember($cacheKey, 3600, function () use ($user) {
            if ($user->id_prodi) {
                return DB::table('program_studi')->where('id_prodi', $user->id_prodi)->value('id_fakultas');
            }

            if ($user->username) {
                $parts = explode('.', $user->username);
                if (count($parts) > 1) {
                    $suffix = end($parts);
                    return DB::table('fakultas')->where('kode_fakultas', 'like', $suffix)->value('id_fakultas');
                }
            }

            return null;
        });
    }

    protected function getAllowedProdiIds($user = null)
    {
        $user = $user ?? Auth::user();

        if ($user->role === 'admin') {
            return null;
        }

        if ($user->role === 'bak_fakultas' || $user->role === 'dekan') {
            $id_fakultas = $this->getFakultasIdFromUser($user);

            if ($id_fakultas) {
                $cacheKey = "fakultas:{$id_fakultas}:prodi_ids";
                return Cache::remember($cacheKey, 3600, function () use ($id_fakultas) {
                    return DB::table('program_studi')->where('id_fakultas', $id_fakultas)->pluck('id_prodi')->toArray();
                });
            }
            return $user->id_prodi ? [$user->id_prodi] : [];
        }

        return $user->id_prodi ? [$user->id_prodi] : [];
    }

    protected function prodiQuery($query, $allowedProdis = null)
    {
        if ($allowedProdis !== null) {
            $query->whereIn('id_prodi', $allowedProdis);
        }
        return $query;
    }

    protected function getProdiOptions($allowedProdis = null)
    {
        if ($allowedProdis === null) {
            return Cache::remember('master:prodi_options', 3600, function () {
                return DB::table('program_studi')->select('id_prodi', 'nama_prodi', 'id_fakultas')->get();
            });
        }
        $cacheKey = 'master:prodi_options:' . md5(implode(',', $allowedProdis));
        return Cache::remember($cacheKey, 3600, function () use ($allowedProdis) {
            return DB::table('program_studi')->whereIn('id_prodi', $allowedProdis)->get();
        });
    }

    protected function getAllowedFakultasIds($user = null)
    {
        $user = $user ?? Auth::user();
        if ($user->role === 'admin') {
            return null;
        }

        $fakultasId = $this->getFakultasIdFromUser($user);
        return $fakultasId ? [$fakultasId] : [];
    }
}
