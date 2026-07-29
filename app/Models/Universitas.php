<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Universitas extends Model
{
    protected $table = 'universitas';
    protected $fillable = [
        'nama_perguruan_tinggi',
        'sk_akreditasi',
        'email',
        'no_telepon',
    ];
}
