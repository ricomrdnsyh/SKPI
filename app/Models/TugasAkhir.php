<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{

    protected $table = 'tugas_akhir';
    protected $primaryKey = 'id_tugas_akhir';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'judul',
        'status',
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
        if ($this->status === 'approved') return 'approved';
        if ($this->approved_by) return 'approved';
        return 'waiting_baak';
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function pembimbing()
    {
        return $this->hasMany(PembimbingTugasAkhir::class, 'id_tugas_akhir', 'id_tugas_akhir');
    }

    public function getPembimbingTugasAkhirAttribute()
    {
        return $this->pembimbing;
    }
}
