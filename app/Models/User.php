<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id_user';
    public $timestamps = false;

    protected $fillable = [
        'username',
        'nama_lengkap',
        'role',
        'id_prodi',
        'email',
        'password',
        'aktif'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'aktif' => 'boolean',
            'password' => 'hashed',
        ];
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }
}
