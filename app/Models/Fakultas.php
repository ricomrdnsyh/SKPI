<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fakultas extends Model
{
    protected $table = 'fakultas';
    protected $primaryKey = 'id_fakultas';
    public $timestamps = false;

    protected $fillable = [
        'nama_fakultas',
        'kode_fakultas',
        'dekan',
        'nidn_dekan',
        'no_telepon',
        'status'
    ];
}
