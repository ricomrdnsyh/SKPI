<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skpi extends Model
{

    protected $table = 'skpi';
    protected $primaryKey = 'id_skpi';
    public $timestamps = false;

    protected $fillable = [
        'nomor_skpi',
        'nim',
        'id_pengajuan',
        'nim_ijazah',
        'tanggal_terbit',
        'dicetak_oleh',
        'status_profesi',
        'tanggal_ttd_dekan',
        'ditandatangani_oleh',
        'nidn_penandatangan',
    ];

    protected $casts = [
        'tanggal_terbit' => 'date',
        'tanggal_ttd_dekan' => 'date',
    ];

    public function getNidnPenandatanganAttribute()
    {
        return $this->attributes['niy_penandatangan'] ?? null;
    }

    public function setNidnPenandatanganAttribute($value)
    {
        $this->attributes['niy_penandatangan'] = $value;
    }
}
