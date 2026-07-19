<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'id_penduduk';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_penduduk',
        'nidn',
        'nama_dosen',
        'jenis_kelamin',
        'email',
        'no_hp',
        'id_fakultas',
        'id_prodi',
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas', 'id_fakultas');
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }
}
