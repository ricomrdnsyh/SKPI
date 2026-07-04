<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramStudi extends Model
{
    protected $table = 'program_studi';
    protected $primaryKey = 'id_prodi';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_prodi',
        'id_fakultas',
        'nama_prodi',
        'kode_prodi',
        'jenjang',
        'gelar',
        'sk_akreditasi',
        'tanggal_sk_akreditasi',
        'masa_berlaku_akreditasi',
        'jenjang_kkni',
        'bahasa_pengantar',
        'lama_studi',
        'jenis_pendidikan',
        'jenis_pendidikan_lanjutan',
        'persyaratan_penerimaan',
        'alamat_prodi',
        'telepon_prodi',
        'email_prodi',
        'status',
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class, 'id_fakultas', 'id_fakultas');
    }
}
