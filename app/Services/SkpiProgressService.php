<?php

namespace App\Services;

use App\Models\Mahasiswa;
use Illuminate\Support\Facades\DB;

class SkpiProgressService
{
    public function __construct(
        private CacheService $cache
    ) {}

    public function getSteps(Mahasiswa $mahasiswa, object|null $pengajuan = null): array
    {
        $mahasiswa->loadMissing(['programStudi.fakultas']);
        $prodi = $mahasiswa->programStudi;
        $fakultasId = $prodi->id_fakultas ?? 0;

        $baakList = \App\Models\User::where('role', 'bak_fakultas')
            ->whereHas('programStudi', function ($query) use ($fakultasId) {
                $query->where('id_fakultas', $fakultasId);
            })->select('id_user', 'nama_lengkap')->get();

        if ($baakList->isEmpty() && $prodi) {
            $baakList = \App\Models\User::where('role', 'bak_fakultas')
                ->where('id_prodi', $prodi->id_prodi)
                ->select('id_user', 'nama_lengkap')->get();
        }

        $baakNames = $baakList->pluck('nama_lengkap')->implode(', ') ?: 'BAAK Fakultas';

        $verifier = null;
        $printer = null;
        $skpi = null;

        if ($pengajuan) {
            $skpi = DB::table('skpi')->where('id_pengajuan', $pengajuan->id_pengajuan)->first();

            $userIds = array_filter([
                $pengajuan->diverifikasi_oleh,
                $skpi->dicetak_oleh ?? null,
            ]);

            $userMap = \App\Models\User::whereIn('id_user', $userIds)->get()->keyBy('id_user');

            $verifier = $userMap->get($pengajuan->diverifikasi_oleh);
            $printer = $skpi ? $userMap->get($skpi->dicetak_oleh) : null;
        }

        $mahasiswa->loadMissing(['prestasi', 'organisasi', 'sertifikat', 'magang']);

        $prestasi = $mahasiswa->prestasi;
        $organisasi = $mahasiswa->organisasi;
        $sertifikat = $mahasiswa->sertifikat;
        $magang = $mahasiswa->magang;

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
