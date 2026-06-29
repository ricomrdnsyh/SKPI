<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChecklistVerifikasiSkpi extends Model
{
    protected $table = 'checklist_verifikasi_skpi';
    protected $primaryKey = 'id_checklist';
    public $timestamps = false;

    protected $fillable = [
        'id_pengajuan',
        'cek_identitas_mahasiswa',
        'cek_identitas_prodi',
        'cek_cpl',
        'cek_prestasi',
        'cek_organisasi',
        'cek_sertifikat',
        'cek_magang',
        'cek_tugas_akhir',
        'cek_sistem_penilaian',
        'hasil_verifikasi',
        'catatan',
        'diverifikasi_oleh',
        'tanggal_verifikasi'
    ];

    protected $casts = [
        'cek_identitas_mahasiswa' => 'boolean',
        'cek_identitas_prodi' => 'boolean',
        'cek_cpl' => 'boolean',
        'cek_prestasi' => 'boolean',
        'cek_organisasi' => 'boolean',
        'cek_sertifikat' => 'boolean',
        'cek_magang' => 'boolean',
        'cek_tugas_akhir' => 'boolean',
        'cek_sistem_penilaian' => 'boolean',
        'tanggal_verifikasi' => 'datetime',
    ];
}
