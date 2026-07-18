<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';

    protected $table = 'kurikulum';
    protected $primaryKey = 'id_kurikulum';

    protected $fillable = [
        'id_kurikulum',
        'id_prodi',
        'nama_kurikulum'
    ];
}
