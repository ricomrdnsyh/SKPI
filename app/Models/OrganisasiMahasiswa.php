<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrganisasiMahasiswa extends Model
{

    protected $table = 'organisasi_mahasiswa';
    protected $primaryKey = 'id_organisasi_mhs';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama_organisasi',
        'tingkat',
        'jabatan',
        'tahun_mulai',
        'tahun_selesai',
        'status',
        'file_bukti',
        'approved_by',
        'approved_at',
        'keterangan'
    ];

    protected $casts = [
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
