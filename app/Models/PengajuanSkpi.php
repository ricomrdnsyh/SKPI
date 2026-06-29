<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanSkpi extends Model
{

    protected $table = 'pengajuan_skpi';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_mahasiswa',
        'tanggal_pengajuan',
        'status',
        'catatan_mahasiswa',
        'diverifikasi_oleh',
        'tanggal_verifikasi',
        'catatan_bak',
        'permohonan_cetak'
    ];

    protected $casts = [
        'tanggal_pengajuan' => 'datetime',
        'tanggal_verifikasi' => 'datetime',
        'permohonan_cetak' => 'boolean'
    ];

}
