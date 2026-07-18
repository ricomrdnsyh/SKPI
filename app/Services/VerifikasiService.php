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

        $pushApprovalHistory = function ($item, $label, $detail) use ($history) {
            if ($item->approved_by && $item->status !== 'rejected') {
                $history->push([
                    'waktu' => $item->approved_at ?? now(),
                    'aksi' => 'Approve ' . $label . ' (BAAK)',
                    'detail' => $detail,
                    'status' => 'approved',
                    'catatan' => 'Disetujui oleh BAAK Fakultas'
                ]);
            }
            if ($item->status === 'rejected') {
                $history->push([
                    'waktu' => $item->approved_at ?? now(),
                    'aksi' => 'Reject ' . $label . ' (BAAK)',
                    'detail' => $detail,
                    'status' => 'rejected',
                    'catatan' => $item->keterangan ?? ''
                ]);
            }
        };

        if ($ta) {
            $history->push(['waktu' => $ta->created_at ?? now(), 'aksi' => 'Submit Tugas Akhir', 'detail' => $ta->judul, 'status' => 'submitted', 'catatan' => '']);
            $pushApprovalHistory($ta, 'Tugas Akhir', $ta->judul);
        }

        foreach ($prestasi as $p) {
            $history->push(['waktu' => $p->created_at ?? $p->approved_at ?? now(), 'aksi' => 'Upload Prestasi', 'detail' => $p->nama_prestasi, 'status' => 'submitted', 'catatan' => '']);
            if ($p->approved_by || $p->status === 'rejected') {
                $pushApprovalHistory($p, 'Prestasi', $p->nama_prestasi);
            }
        }
        foreach ($organisasi as $o) {
            $history->push(['waktu' => $o->created_at ?? $o->approved_at ?? now(), 'aksi' => 'Upload Organisasi', 'detail' => $o->nama_organisasi, 'status' => 'submitted', 'catatan' => '']);
            if ($o->approved_by || $o->status === 'rejected') {
                $pushApprovalHistory($o, 'Organisasi', $o->nama_organisasi);
            }
        }
        foreach ($sertifikat as $s) {
            $history->push(['waktu' => $s->created_at ?? $s->approved_at ?? now(), 'aksi' => 'Upload Sertifikat', 'detail' => $s->nama_sertifikat, 'status' => 'submitted', 'catatan' => '']);
            if ($s->approved_by || $s->status === 'rejected') {
                $pushApprovalHistory($s, 'Sertifikat', $s->nama_sertifikat);
            }
        }
        foreach ($magang as $m) {
            $history->push(['waktu' => $m->created_at ?? $m->approved_at ?? now(), 'aksi' => 'Upload Magang', 'detail' => $m->tempatMagang->nama_perusahaan ?? $m->posisi, 'status' => 'submitted', 'catatan' => '']);
            if ($m->approved_by || $m->status === 'rejected') {
                $pushApprovalHistory($m, 'Magang', $m->tempatMagang->nama_perusahaan ?? $m->posisi);
            }
        }

        if ($pengajuan->tanggal_pengajuan) {
            $history->push(['waktu' => $pengajuan->tanggal_pengajuan, 'aksi' => 'Pengajuan Cetak SKPI', 'detail' => 'Mahasiswa mengajukan cetak SKPI', 'status' => 'submitted', 'catatan' => $pengajuan->catatan_mahasiswa]);
        }
        if ($pengajuan->tanggal_verifikasi) {
            $statusVerif = $pengajuan->status === 'ditolak' ? 'rejected' : 'approved';
            $history->push(['waktu' => $pengajuan->tanggal_verifikasi, 'aksi' => 'Verifikasi BAAK Fakultas', 'detail' => 'BAAK memproses pengajuan cetak', 'status' => $statusVerif, 'catatan' => $pengajuan->catatan_bak]);
        }

        if ($skpi && $skpi->tanggal_terbit) {
            $history->push(['waktu' => $skpi->tanggal_terbit, 'aksi' => 'Cetak SKPI', 'detail' => 'Nomor: ' . ($skpi->nomor_skpi ?? '-'), 'status' => 'dicetak', 'catatan' => '']);
        }

        return $history->sortByDesc('waktu')->values();
    }
}
