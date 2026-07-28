<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    protected $primaryKey = 'id_fakultas';
    public $timestamps = false;

    protected $fillable = [
        'kode_fakultas',
        'nama_fakultas',
        'dekan',
        'niy_dekan',
        'status',
    ];
}
