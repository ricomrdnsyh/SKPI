<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Mahasiswa extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'nim',
        'id_prodi',
        'id_kurikulum',
        'nama_lengkap',
        'tempat_lahir',
        'tanggal_lahir',
        'tahun_masuk',
        'tahun_lulus',
        'tanggal_lulus',
        'status',
        'ipk',
        'foto',
        'email',
        'nomor_telepon',
        'password',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'tanggal_lahir' => 'date',
            'tanggal_lulus' => 'date',
            'ipk' => 'decimal:2',
        ];
    }

    public function getAuthIdentifierName()
    {
        return 'nim';
    }

    public function getRoleAttribute(): string
    {
        return 'mahasiswa';
    }

    public function getAktifAttribute(): bool
    {
        return in_array($this->status, ['Aktif', 'Lulus']);
    }

    public function programStudi()
    {
        return $this->belongsTo(ProgramStudi::class, 'id_prodi', 'id_prodi');
    }

    public function kurikulum()
    {
        return $this->belongsTo(Kurikulum::class, 'id_kurikulum', 'id_kurikulum');
    }

    public function prestasi()
    {
        return $this->hasMany(PrestasiMahasiswa::class, 'nim', 'nim');
    }

    public function organisasi()
    {
        return $this->hasMany(OrganisasiMahasiswa::class, 'nim', 'nim');
    }

    public function sertifikat()
    {
        return $this->hasMany(SertifikatMahasiswa::class, 'nim', 'nim');
    }

    public function magang()
    {
        return $this->hasMany(MagangMahasiswa::class, 'nim', 'nim');
    }

    public function tugasAkhir()
    {
        return $this->hasOne(TugasAkhir::class, 'nim', 'nim');
    }

    public function pengajuanSkpi()
    {
        return $this->hasOne(PengajuanSkpi::class, 'nim', 'nim');
    }

    public function skpi()
    {
        return $this->hasOne(Skpi::class, 'nim', 'nim');
    }

    private array $progressStepsCache = [];

    public function getSkpiProgressSteps($pengajuan = null): array
    {
        $pengajuanId = $pengajuan ? (is_numeric($pengajuan) ? $pengajuan : ($pengajuan->id_pengajuan ?? 0)) : 0;
        if (!isset($this->progressStepsCache[$pengajuanId])) {
            $this->progressStepsCache[$pengajuanId] = app(\App\Services\SkpiProgressService::class)->getSteps($this, $pengajuan);
        }
        return $this->progressStepsCache[$pengajuanId];
    }

    public function allPrestasiApproved(): bool
    {
        return !$this->prestasi()->where('status', 'pending')->exists();
    }

    public function allOrganisasiApproved(): bool
    {
        return !$this->organisasi()->where('status', 'pending')->exists();
    }

    public function allSertifikatApproved(): bool
    {
        return !$this->sertifikat()->where('status', 'pending')->exists();
    }

    public function allMagangApproved(): bool
    {
        return !$this->magang()->where('status', 'pending')->exists();
    }

    public function tugasAkhirApproved(): bool
    {
        $ta = $this->tugasAkhir;
        return $ta && $ta->status === 'approved' && !empty($ta->judul);
    }

    public function allModulesApproved(): bool
    {
        return $this->tugasAkhirApproved();
    }

    public function hasAnyPending(): bool
    {
        return $this->prestasi()->where('status', 'pending')->exists()
            || $this->organisasi()->where('status', 'pending')->exists()
            || $this->sertifikat()->where('status', 'pending')->exists()
            || $this->magang()->where('status', 'pending')->exists()
            || $this->tugasAkhir()->where('status', 'pending')->exists();
    }
}
