<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory;

    protected $table = 'tahun_akademik';
    protected $primaryKey = 'id_tahun_akademik';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_tahun_akademik',
        'nama',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
