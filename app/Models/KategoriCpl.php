<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriCpl extends Model
{
    protected $table = 'kategori_cpl';
    protected $primaryKey = 'id_kategori';
    public $timestamps = false;

    protected $fillable = [
        'kode_kategori',
        'nama_kategori',
        'urutan'
    ];
}
