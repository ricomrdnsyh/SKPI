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

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function skpi()
    {
        return $this->hasOne(Skpi::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function checklist()
    {
        return $this->hasOne(ChecklistVerifikasiSkpi::class, 'id_pengajuan', 'id_pengajuan');
    }

    public function scopeHasPendingItems($query)
    {
        return $query->where('pengajuan_skpi.status', 'diajukan')
            ->orWhere(function ($sub) {
                $sub->where('pengajuan_skpi.status', '<>', 'dicetak')
                    ->whereHas('mahasiswa', function ($mhs) {
                        $mhs->whereHas('prestasi', fn($q) => $q->where('status', 'pending'))
                            ->orWhereHas('organisasi', fn($q) => $q->where('status', 'pending'))
                            ->orWhereHas('sertifikat', fn($q) => $q->where('status', 'pending'))
                            ->orWhereHas('magang', fn($q) => $q->where('status', 'pending'))
                            ->orWhereHas('tugasAkhir', fn($q) => $q->where('status', 'pending'));
                    });
            });
    }
}
