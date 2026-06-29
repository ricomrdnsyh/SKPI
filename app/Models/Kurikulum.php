<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    public $timestamps = false;

    protected $table = 'kurikulum';
    protected $primaryKey = 'id_kurikulum';

    protected $fillable = [
        'id_prodi',
        'nama_kurikulum',
        'tahun'
    ];

    protected $casts = [
        'tahun' => 'integer',
    ];
}
