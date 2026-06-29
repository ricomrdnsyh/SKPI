<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SistemPenilaian extends Model
{
    protected $table = 'sistem_penilaian';
    protected $primaryKey = 'id_penilaian';
    public $timestamps = false;

    protected $fillable = [
        'nilai_huruf',
        'nilai_min',
        'nilai_max'
    ];
}
