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
    protected $primaryKey = 'id_mahasiswa';
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
        ];
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

    public function prestasi()
    {
        return $this->hasMany(PrestasiMahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function organisasi()
    {
        return $this->hasMany(OrganisasiMahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function sertifikat()
    {
        return $this->hasMany(SertifikatMahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function magang()
    {
        return $this->hasMany(MagangMahasiswa::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function tugasAkhir()
    {
        return $this->hasOne(TugasAkhir::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function pengajuanSkpi()
    {
        return $this->hasOne(PengajuanSkpi::class, 'id_mahasiswa', 'id_mahasiswa');
    }

    public function skpi()
    {
        return $this->hasOne(Skpi::class, 'id_mahasiswa', 'id_mahasiswa');
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
