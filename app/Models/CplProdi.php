<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CplProdi extends Model
{
    protected $table = 'cpl_prodi';
    protected $primaryKey = 'id_cpl';
    public $timestamps = false;

    protected $fillable = [
        'id_prodi',
        'id_kurikulum',
        'id_kategori',
        'kode_cpl',
        'deskripsi_cpl',
        'urutan'
    ];
}
