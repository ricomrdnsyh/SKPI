<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MagangMahasiswa extends Model
{

    protected $table = 'magang_mahasiswa';
    protected $primaryKey = 'id_magang';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'tempat_magang',
        'posisi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'file_bukti',
        'approved_by',
        'approved_at',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
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
