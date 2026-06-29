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

    // ---- Preloaded Data Properties (Query Builder Optimization) ----

    public ?\Illuminate\Support\Collection $preloaded_prestasi = null;
    public ?\Illuminate\Support\Collection $preloaded_organisasi = null;
    public ?\Illuminate\Support\Collection $preloaded_sertifikat = null;
    public ?\Illuminate\Support\Collection $preloaded_magang = null;
    public ?object $preloaded_tugas_akhir = null;
    public ?object $programStudi = null;

    public static function preloadRelations(iterable $mahasiswas)
    {
        if (empty($mahasiswas)) {
            return;
        }

        $studentIds = [];
        foreach ($mahasiswas as $mhs) {
            $studentIds[] = $mhs->id_mahasiswa;
        }
        $studentIds = array_unique(array_filter($studentIds));

        if (empty($studentIds)) {
            return;
        }

        $prestasis = DB::table('prestasi_mahasiswa')->whereIn('id_mahasiswa', $studentIds)->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $organisasis = DB::table('organisasi_mahasiswa')->whereIn('id_mahasiswa', $studentIds)->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $sertifikats = DB::table('sertifikat_mahasiswa')->whereIn('id_mahasiswa', $studentIds)->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $magangs = DB::table('magang_mahasiswa')->whereIn('id_mahasiswa', $studentIds)->select(['id_mahasiswa', 'status', 'approved_by', 'approved_at'])->get()->groupBy('id_mahasiswa');
        $tugasAkhirs = DB::table('tugas_akhir')->whereIn('id_mahasiswa', $studentIds)->select(['id_mahasiswa', 'id_tugas_akhir', 'status', 'approved_by', 'judul'])->get()->keyBy('id_mahasiswa');

        $prodiIds = [];
        foreach ($mahasiswas as $mhs) {
            if ($mhs->id_prodi) {
                $prodiIds[] = $mhs->id_prodi;
            }
        }
        $prodiIds = array_unique(array_filter($prodiIds));

        $programStudis = collect();
        if (!empty($prodiIds)) {
            $programStudis = DB::table('program_studi')->whereIn('id_prodi', $prodiIds)->get()->keyBy('id_prodi');
        }

        foreach ($mahasiswas as $mhs) {
            $mhs->preloaded_prestasi = $prestasis->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_organisasi = $organisasis->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_sertifikat = $sertifikats->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_magang = $magangs->get($mhs->id_mahasiswa) ?? collect();
            $mhs->preloaded_tugas_akhir = $tugasAkhirs->get($mhs->id_mahasiswa);
            $mhs->programStudi = $programStudis->get($mhs->id_prodi);
        }
    }

    // ---- Progress and Verification ----

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
        if ($this->preloaded_prestasi !== null) {
            return $this->preloaded_prestasi->where('status', 'pending')->count() === 0;
        }
        return !DB::table('prestasi_mahasiswa')
            ->where('id_mahasiswa', $this->id_mahasiswa)
            ->where('status', 'pending')
            ->exists();
    }

    public function allOrganisasiApproved(): bool
    {
        if ($this->preloaded_organisasi !== null) {
            return $this->preloaded_organisasi->where('status', 'pending')->count() === 0;
        }
        return !DB::table('organisasi_mahasiswa')
            ->where('id_mahasiswa', $this->id_mahasiswa)
            ->where('status', 'pending')
            ->exists();
    }

    public function allSertifikatApproved(): bool
    {
        if ($this->preloaded_sertifikat !== null) {
            return $this->preloaded_sertifikat->where('status', 'pending')->count() === 0;
        }
        return !DB::table('sertifikat_mahasiswa')
            ->where('id_mahasiswa', $this->id_mahasiswa)
            ->where('status', 'pending')
            ->exists();
    }

    public function allMagangApproved(): bool
    {
        if ($this->preloaded_magang !== null) {
            return $this->preloaded_magang->where('status', 'pending')->count() === 0;
        }
        return !DB::table('magang_mahasiswa')
            ->where('id_mahasiswa', $this->id_mahasiswa)
            ->where('status', 'pending')
            ->exists();
    }

    public function tugasAkhirApproved(): bool
    {
        $ta = $this->preloaded_tugas_akhir !== null 
            ? $this->preloaded_tugas_akhir 
            : DB::table('tugas_akhir')->where('id_mahasiswa', $this->id_mahasiswa)->first();
        return $ta && $ta->status === 'approved' && !empty($ta->judul);
    }

    public function allModulesApproved(): bool
    {
        return $this->tugasAkhirApproved();
    }

    public function hasAnyPending(): bool
    {
        if ($this->preloaded_prestasi !== null && $this->preloaded_organisasi !== null && $this->preloaded_sertifikat !== null && $this->preloaded_magang !== null) {
            $ta = $this->preloaded_tugas_akhir;
            return $this->preloaded_prestasi->where('status', 'pending')->isNotEmpty()
                || $this->preloaded_organisasi->where('status', 'pending')->isNotEmpty()
                || $this->preloaded_sertifikat->where('status', 'pending')->isNotEmpty()
                || $this->preloaded_magang->where('status', 'pending')->isNotEmpty()
                || ($ta && $ta->status === 'pending');
        }

        $id = $this->id_mahasiswa;
        return DB::selectOne("
            SELECT 1 FROM (
                (SELECT id_mahasiswa FROM prestasi_mahasiswa WHERE id_mahasiswa = ? AND status = 'pending' LIMIT 1)
                UNION ALL
                (SELECT id_mahasiswa FROM organisasi_mahasiswa WHERE id_mahasiswa = ? AND status = 'pending' LIMIT 1)
                UNION ALL
                (SELECT id_mahasiswa FROM sertifikat_mahasiswa WHERE id_mahasiswa = ? AND status = 'pending' LIMIT 1)
                UNION ALL
                (SELECT id_mahasiswa FROM magang_mahasiswa WHERE id_mahasiswa = ? AND status = 'pending' LIMIT 1)
                UNION ALL
                (SELECT id_mahasiswa FROM tugas_akhir WHERE id_mahasiswa = ? AND status = 'pending' LIMIT 1)
            ) t LIMIT 1
        ", [$id, $id, $id, $id, $id]) !== null;
    }
}
