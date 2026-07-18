<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrestasiMahasiswa extends Model
{

    protected $table = 'prestasi_mahasiswa';
    protected $primaryKey = 'id_prestasi';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'nama_prestasi',
        'tingkat',
        'peringkat',
        'penyelenggara',
        'tahun',
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
