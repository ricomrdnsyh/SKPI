<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembimbingTugasAkhir extends Model
{
    protected $table = 'pembimbing_tugas_akhir';
    protected $primaryKey = 'id_pembimbing_ta';
    public $timestamps = false;

    protected $fillable = [
        'id_tugas_akhir',
        'nama_dosen',
        'urutan_pembimbing'
    ];
}
