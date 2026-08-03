<?php

namespace App\Services;

use App\Models\ChecklistVerifikasiSkpi;
use App\Models\MagangMahasiswa;
use App\Models\OrganisasiMahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\PrestasiMahasiswa;
use App\Models\SertifikatMahasiswa;
use App\Models\TugasAkhir;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VerifikasiService
{
    public function __construct(
    ) {}

    public function submitChecklist(PengajuanSkpi $pengajuan, array $data, User $user): void
    {
        $val = $data['hasil_verifikasi'] === 'lulus' ? 1 : 0;

        ChecklistVerifikasiSkpi::updateOrCreate(
            ['id_pengajuan' => $pengajuan->id_pengajuan],
            [
                'cek_identitas_mahasiswa' => $val,
                'cek_identitas_prodi' => $val,
                'cek_cpl' => $val,
                'cek_prestasi' => $val,
                'cek_organisasi' => $val,
                'cek_sertifikat' => $val,
                'cek_magang' => $val,
                'cek_tugas_akhir' => $val,
                'cek_sistem_penilaian' => $val,
                'hasil_verifikasi' => $data['hasil_verifikasi'],
                'catatan' => $data['catatan'] ?? null,
                'diverifikasi_oleh' => $user->id_user,
                'tanggal_verifikasi' => now(),
            ]
        );

        $pengajuan->diverifikasi_oleh = $user->id_user;
        $pengajuan->tanggal_verifikasi = now();
        $pengajuan->catatan_bak = $data['catatan'] ?? null;

        $pengajuan->status = match ($data['hasil_verifikasi']) {
            'lulus' => 'verifikasi',
            'perlu_revisi' => 'draft',
            default => 'ditolak',
        };

        $pengajuan->save();
    }

    public function getHistoryTimeline(PengajuanSkpi $pengajuan): \Illuminate\Support\Collection
    {
        $mahasiswaId = $pengajuan->nim;

        $prestasi = \App\Models\PrestasiMahasiswa::where('nim', $mahasiswaId)->get();
        $organisasi = \App\Models\OrganisasiMahasiswa::where('nim', $mahasiswaId)->get();
        $sertifikat = \App\Models\SertifikatMahasiswa::where('nim', $mahasiswaId)->get();
        $magang = \App\Models\MagangMahasiswa::where('nim', $mahasiswaId)->get()
            ->map(function ($item) {
                $item->tempatMagang = (object) [
                    'nama_perusahaan' => $item->tempat_magang,
                    'alamat' => '',
                ];
                return $item;
            });

        $ta = \App\Models\TugasAkhir::where('nim', $mahasiswaId)->first();
        $skpi = \App\Models\Skpi::where('id_pengajuan', $pengajuan->id_pengajuan)->first();

        $history = collect();

        $parseWaktu = function ($waktu) {
            return $waktu ? \Carbon\Carbon::parse($waktu) : now();
        };

        $parseWaktu = function ($waktu, $fallback = null, $addMinutes = 0) {
            if ($waktu) return \Carbon\Carbon::parse($waktu);
            if ($fallback) return \Carbon\Carbon::parse($fallback)->addMinutes($addMinutes);
            return now();
        };

        $addCategorizedHistory = function($items, $kategori) use ($history, $parseWaktu, $pengajuan) {
            if ($items->isEmpty()) return;

            $getName = function($item) use ($kategori) {
                if ($kategori === 'Tugas Akhir') return $item->judul ?? 'Tugas Akhir';
                if ($kategori === 'Magang') return $item->tempatMagang->nama_perusahaan ?? $item->posisi ?? 'Magang';
                $field = 'nama_' . strtolower($kategori);
                return $item->$field ?? $kategori;
            };

            $getTimestamp = function($val) {
                return $val ? \Carbon\Carbon::parse($val)->timestamp : null;
            };

            // 1. Uploads (Earliest creation time)
            $minCreatedTs = $items->map(fn($i) => $getTimestamp($i->created_at))->filter()->min();
            $earliestUpload = $minCreatedTs ? \Carbon\Carbon::createFromTimestamp($minCreatedTs) : null;

            if (!$earliestUpload) {
                // Fallback logis jika created_at null
                $minApprovedTs = $items->map(fn($i) => $getTimestamp($i->approved_at))->filter()->min();
                $earliestUpload = $minApprovedTs 
                    ? \Carbon\Carbon::createFromTimestamp($minApprovedTs)->subMinutes(2) 
                    : ($pengajuan->tanggal_pengajuan ? \Carbon\Carbon::parse($pengajuan->tanggal_pengajuan)->subMinutes(5) : now());
            }

            $uploadNames = $items->map($getName)->filter()->implode(', ');
            $history->push([
                'waktu' => $parseWaktu($earliestUpload),
                'aksi' => 'Upload Data ' . $kategori,
                'detail' => $uploadNames,
                'status' => 'submitted',
                'catatan' => ''
            ]);

            // 2. Approvals (Grouped)
            $approvedItems = $items->filter(function($i) { return $i->approved_by && $i->status !== 'rejected'; });
            if ($approvedItems->isNotEmpty()) {
                $maxApproveTs = $approvedItems->map(fn($i) => $getTimestamp($i->approved_at))->filter()->max();
                $latestApprove = $maxApproveTs ? \Carbon\Carbon::createFromTimestamp($maxApproveTs) : null;

                $history->push([
                    'waktu' => $parseWaktu($latestApprove, $earliestUpload, 1),
                    'aksi' => 'Validasi ' . $kategori,
                    'detail' => $approvedItems->count() . ' data ' . $kategori . ' telah disetujui (BAAK)',
                    'status' => 'approved',
                    'catatan' => ''
                ]);
            }

            // 3. Rejections (Individual)
            $rejectedItems = $items->filter(function($i) { return $i->status === 'rejected'; });
            foreach($rejectedItems as $rj) {
                $history->push([
                    'waktu' => $parseWaktu($rj->approved_at, $earliestUpload, 1),
                    'aksi' => 'Revisi ' . $kategori,
                    'detail' => $getName($rj),
                    'status' => 'rejected',
                    'catatan' => $rj->keterangan ?? 'Data tidak valid, butuh perbaikan'
                ]);
            }

            // 4. Updates / Resubmissions
            $updatedItems = $items->filter(function($i) { 
                return $i->status === 'pending' && $i->updated_at && $i->created_at && $i->updated_at->diffInMinutes($i->created_at) > 5; 
            });
            if ($updatedItems->isNotEmpty()) {
                $maxUpdateTs = $updatedItems->map(fn($i) => $getTimestamp($i->updated_at))->filter()->max();
                $latestUpdate = $maxUpdateTs ? \Carbon\Carbon::createFromTimestamp($maxUpdateTs) : null;

                $history->push([
                    'waktu' => $parseWaktu($latestUpdate),
                    'aksi' => 'Perbaikan Data ' . $kategori,
                    'detail' => 'Mahasiswa memperbarui ' . $updatedItems->count() . ' data ' . $kategori,
                    'status' => 'submitted',
                    'catatan' => ''
                ]);
            }
        };

        if ($ta) {
            $addCategorizedHistory(collect([$ta]), 'Tugas Akhir');
        }
        $addCategorizedHistory($prestasi, 'Prestasi');
        $addCategorizedHistory($organisasi, 'Organisasi');
        $addCategorizedHistory($sertifikat, 'Sertifikat');
        $addCategorizedHistory($magang, 'Magang');

        if ($pengajuan->tanggal_pengajuan) {
            $history->push(['waktu' => $parseWaktu($pengajuan->tanggal_pengajuan), 'aksi' => 'Pengajuan SKPI', 'detail' => 'Mahasiswa mengajukan validasi akhir dan cetak SKPI', 'status' => 'submitted', 'catatan' => $pengajuan->catatan_mahasiswa]);
        }
        if ($pengajuan->tanggal_verifikasi) {
            $statusVerif = $pengajuan->status === 'ditolak' ? 'rejected' : 'approved';
            $history->push(['waktu' => $parseWaktu($pengajuan->tanggal_verifikasi), 'aksi' => 'Verifikasi Akhir BAAK', 'detail' => 'Review pengajuan cetak oleh BAAK', 'status' => $statusVerif, 'catatan' => $pengajuan->catatan_bak]);
        }

        if ($skpi && $skpi->tanggal_terbit) {
            // Gunakan jam dari updated_at pengajuan saat status berubah menjadi dicetak agar jamnya presisi
            $waktuTerbit = $pengajuan->updated_at && $pengajuan->status === 'dicetak' 
                ? \Carbon\Carbon::parse($pengajuan->updated_at) 
                : \Carbon\Carbon::parse($skpi->tanggal_terbit)->endOfDay();
                
            $history->push(['waktu' => $waktuTerbit, 'aksi' => 'Penerbitan SKPI', 'detail' => 'Nomor: ' . ($skpi->nomor_skpi ?? '-'), 'status' => 'dicetak', 'catatan' => 'SKPI Resmi Diterbitkan']);
        }

        return $history->sortByDesc(function ($item) {
            return $item['waktu']->timestamp;
        })->values();
    }
}
