<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class SkpiProgressService
{
    public function __construct(
        private CacheService $cache,
        private DataPreloader $preloader
    ) {}

    public function getSteps(Mahasiswa $mahasiswa, object|null $pengajuan = null): array
    {
        $prodi = $this->preloader->getProdi($mahasiswa->id_prodi);
        $fakultasId = $prodi->id_fakultas ?? 0;

        $baakList = $this->preloader->getBaakForFakultas($fakultasId, $mahasiswa->id_prodi ?? 0);
        $baakNames = $baakList->map(fn($u) => $u->nama_lengkap)->implode(', ') ?: 'BAAK Fakultas';

        $userIds = [];
        $verifier = null;
        $printer = null;
        $skpi = null;

        if ($pengajuan) {
            $skpi = DB::table('skpi')->where('id_pengajuan', $pengajuan->id_pengajuan)->first();

            $userIds = array_filter([
                $pengajuan->diverifikasi_oleh,
                $skpi->dicetak_oleh ?? null,
            ]);

            $userMap = $this->preloader->getUsersBatch($userIds)->keyBy('id_user');

            $verifier = $userMap->get($pengajuan->diverifikasi_oleh);
            $printer = $skpi ? $userMap->get($skpi->dicetak_oleh) : null;
        }

        $id = $mahasiswa->id_mahasiswa;
        $selectCols = ['status', 'approved_by', 'approved_at'];

        $prestasi = $mahasiswa->preloaded_prestasi !== null
            ? $mahasiswa->preloaded_prestasi
            : DB::table('prestasi_mahasiswa')->where('id_mahasiswa', $id)->select($selectCols)->get();

        $organisasi = $mahasiswa->preloaded_organisasi !== null
            ? $mahasiswa->preloaded_organisasi
            : DB::table('organisasi_mahasiswa')->where('id_mahasiswa', $id)->select($selectCols)->get();

        $sertifikat = $mahasiswa->preloaded_sertifikat !== null
            ? $mahasiswa->preloaded_sertifikat
            : DB::table('sertifikat_mahasiswa')->where('id_mahasiswa', $id)->select($selectCols)->get();

        $magang = $mahasiswa->preloaded_magang !== null
            ? $mahasiswa->preloaded_magang
            : DB::table('magang_mahasiswa')->where('id_mahasiswa', $id)->select($selectCols)->get();

        $allItems = collect()
            ->concat($prestasi)
            ->concat($organisasi)
            ->concat($sertifikat)
            ->concat($magang);

        $totalItemsCount = $allItems->count();
        $pendingItemsCount = $allItems->filter(fn($item) => $item->status === 'pending')->count();
        $approvedItemsCount = $allItems->where('status', 'approved')->count();
        $rejectedItemsCount = $allItems->where('status', 'rejected')->count();

        $steps = [
            1 => [
                'name' => 'Pengajuan Cetak SKPI',
                'desc' => 'Mahasiswa mengajukan permohonan cetak SKPI',
                'status' => 'belum',
                'date' => null,
                'handler' => $mahasiswa->nama_lengkap
            ],
            2 => [
                'name' => 'Verifikasi BAAK Fakultas',
                'desc' => 'BAAK Fakultas memverifikasi data dan pengajuan cetak',
                'status' => 'belum',
                'date' => null,
                'handler' => $baakNames
            ],
            3 => [
                'name' => 'Cetak SKPI',
                'desc' => 'Dokumen SKPI resmi diterbitkan',
                'status' => 'belum',
                'date' => null,
                'handler' => $baakNames
            ],
        ];

        if ($pengajuan) {
            $status = $pengajuan->status;

            $steps[1]['status'] = 'sudah';
            $steps[1]['date'] = $pengajuan->tanggal_pengajuan;

            if ($pengajuan->diverifikasi_oleh || in_array($status, ['verifikasi', 'dicetak', 'ditolak'])) {
                $steps[2]['status'] = 'sudah';
                $steps[2]['date'] = $pengajuan->tanggal_verifikasi ?? $pengajuan->tanggal_pengajuan;
                if ($verifier) {
                    $steps[2]['handler'] = $verifier->nama_lengkap;
                }
            } else {
                $steps[2]['status'] = 'belum';
            }

            if ($status === 'dicetak') {
                $steps[3]['status'] = 'sudah';
                if ($skpi) {
                    $steps[3]['date'] = $skpi->tanggal_terbit;
                    if ($printer) {
                        $steps[3]['handler'] = $printer->nama_lengkap;
                    }
                }
            }

            if ($status === 'ditolak') {
                if ($pengajuan->diverifikasi_oleh) {
                    $steps[2]['status'] = 'ditolak';
                } else {
                    $steps[1]['status'] = 'ditolak';
                }
            }
        }

        return $steps;
    }
}
