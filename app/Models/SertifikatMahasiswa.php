<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SertifikatMahasiswa extends Model
{

    protected $table = 'sertifikat_mahasiswa';
    protected $primaryKey = 'id_sertifikat';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama_sertifikat',
        'jenis_sertifikat',
        'bidang',
        'penyelenggara',
        'tanggal_terbit',
        'status',
        'file_bukti',
        'approved_by',
        'approved_at',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'approved_at' => 'datetime',
    ];

    public function getCurrentStageAttribute(): string
    {
        if ($this->status === 'rejected') return 'rejected';
        if ($this->status === 'approved' || $this->approved_by) return 'approved';
        return 'waiting_baak';
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }
}
