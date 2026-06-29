<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TugasAkhir extends Model
{

    protected $table = 'tugas_akhir';
    protected $primaryKey = 'id_tugas_akhir';
    public $timestamps = false;

    protected $fillable = [
        'id_mahasiswa',
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
}
