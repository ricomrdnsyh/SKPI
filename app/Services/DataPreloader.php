<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class DataPreloader
{
    private array $resolvedFakultas = [];
    private array $resolvedProdi = [];
    private array $resolvedUsers = [];
    private CacheService $cache;

    private const MAX_CACHE_SIZE = 500;

    public function __construct(CacheService $cache)
    {
        $this->cache = $cache;
    }

    private function guardMemory(array &$cache, string $key): void
    {
        if (count($cache) >= self::MAX_CACHE_SIZE) {
            reset($cache);
            $firstKey = key($cache);
            unset($cache[$firstKey]);
        }
    }

    public function getFakultas($id): ?object
    {
        if (!$id) return null;
        $id = (int)$id;
        if (!isset($this->resolvedFakultas[$id])) {
            $this->guardMemory($this->resolvedFakultas, $id);
            $this->resolvedFakultas[$id] = $this->cache->getFakultasById($id)
                ?? DB::table('fakultas')->where('id_fakultas', $id)->first();
        }
        return $this->resolvedFakultas[$id];
    }

    public function getProdi($id): ?object
    {
        if (!$id) return null;
        $id = (int)$id;
        if (!isset($this->resolvedProdi[$id])) {
            $this->guardMemory($this->resolvedProdi, $id);
            $this->resolvedProdi[$id] = $this->cache->getProgramStudiById($id)
                ?? DB::table('program_studi')->where('id_prodi', $id)->first();
        }
        return $this->resolvedProdi[$id];
    }

    public function getProdiByFakultas($fakultasId): \Illuminate\Support\Collection
    {
        if (!$fakultasId) return collect();
        $fakultasId = (int)$fakultasId;
        $key = "prodi_fak:{$fakultasId}";
        if (!isset($this->resolvedProdi[$key])) {
            $this->guardMemory($this->resolvedProdi, $key);
            $this->resolvedProdi[$key] = $this->cache->getAllProgramStudi()
                ->where('id_fakultas', $fakultasId)
                ->pluck('id_prodi');
        }
        return $this->resolvedProdi[$key];
    }

    public function getBaakForFakultas($fakultasId, $prodiId): \Illuminate\Support\Collection
    {
        $fakultasId = (int)$fakultasId;
        $prodiId = (int)$prodiId;
        $key = "baak:f{$fakultasId}_p{$prodiId}";
        if (!isset($this->resolvedUsers[$key])) {
            $this->guardMemory($this->resolvedUsers, $key);
            $prodiIds = $this->getProdiByFakultas($fakultasId);
            $baakList = DB::table('users')->where('role', 'bak_fakultas')
                ->whereIn('id_prodi', $prodiIds)
                ->select(['id_user', 'nama_lengkap'])
                ->get();
            if ($baakList->isEmpty()) {
                $baakList = DB::table('users')->where('role', 'bak_fakultas')
                    ->where('id_prodi', $prodiId)
                    ->select(['id_user', 'nama_lengkap'])
                    ->get();
            }
            $this->resolvedUsers[$key] = $baakList;
        }
        return $this->resolvedUsers[$key];
    }



    public function getUsersBatch(array $ids): \Illuminate\Support\Collection
    {
        $ids = array_unique(array_filter($ids));
        if (empty($ids)) return collect();

        $missing = [];
        foreach ($ids as $id) {
            if (!isset($this->resolvedUsers["uid:{$id}"])) {
                $missing[] = $id;
            }
        }

        if (!empty($missing)) {
            $rows = DB::table('users')->whereIn('id_user', $missing)
                ->select(['id_user', 'nama_lengkap', 'username', 'role'])
                ->get();
            foreach ($rows as $row) {
                $this->guardMemory($this->resolvedUsers, "uid:{$row->id_user}");
                $this->resolvedUsers["uid:{$row->id_user}"] = $row;
            }
        }

        return collect($ids)->map(fn($id) => $this->resolvedUsers["uid:{$id}"] ?? null)->filter();
    }

    public function getUser($id): ?object
    {
        if (!$id) return null;
        $id = (int)$id;
        return $this->getUsersBatch([$id])->first();
    }

    public function preloadMahasiswaItems(iterable $mahasiswas): void
    {
        $studentIds = [];
        foreach ($mahasiswas as $mhs) {
            $studentIds[] = $mhs->id_mahasiswa;
        }
        $studentIds = array_unique(array_filter($studentIds));
        if (empty($studentIds)) return;

        $prestasis = DB::table('prestasi_mahasiswa')->whereIn('id_mahasiswa', $studentIds)
            ->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $organisasis = DB::table('organisasi_mahasiswa')->whereIn('id_mahasiswa', $studentIds)
            ->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $sertifikats = DB::table('sertifikat_mahasiswa')->whereIn('id_mahasiswa', $studentIds)
            ->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $magangs = DB::table('magang_mahasiswa')->whereIn('id_mahasiswa', $studentIds)
            ->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $tugasAkhirs = DB::table('tugas_akhir')->whereIn('id_mahasiswa', $studentIds)
            ->select(['id_mahasiswa', 'id_tugas_akhir', 'status', 'approved_by', 'judul'])->get()->keyBy('id_mahasiswa');

        foreach ($mahasiswas as $mhs) {
            $mhs->preloaded_prestasi = $prestasis->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_organisasi = $organisasis->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_sertifikat = $sertifikats->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_magang = $magangs->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_tugas_akhir = $tugasAkhirs->get($mhs->id_mahasiswa);
        }
    }
}
