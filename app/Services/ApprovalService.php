<?php

namespace App\Services;

use App\Models\Approval;
use App\Models\MagangMahasiswa;
use App\Models\OrganisasiMahasiswa;
use App\Models\PengajuanSkpi;
use App\Models\PrestasiMahasiswa;
use App\Models\SertifikatMahasiswa;
use App\Models\TugasAkhir;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ApprovalService
{
    private CacheService $cache;

    public function __construct(CacheService $cache)
    {
        $this->cache = $cache;
    }

    private function flushRelatedCaches(int $mahasiswaId, ?int $pengajuanId = null): void
    {
        if (!$pengajuanId && $mahasiswaId) {
            $pengajuanId = DB::table('pengajuan_skpi')->where('id_mahasiswa', $mahasiswaId)->value('id_pengajuan');
        }
        $this->cache->flushDashboard($mahasiswaId);
        if ($pengajuanId) {
            $this->cache->flushDetail($pengajuanId);
        }
        \Illuminate\Support\Facades\Cache::forget('master:pengajuan_statuses');
    }

    private function flushByItem(string $type, $id): void
    {
        $table = match ($type) {
            'prestasi' => 'prestasi_mahasiswa',
            'organisasi' => 'organisasi_mahasiswa',
            'sertifikat' => 'sertifikat_mahasiswa',
            'magang' => 'magang_mahasiswa',
            default => null,
        };
        if ($table) {
            $item = DB::table($table)->where(match ($type) {
                'prestasi' => 'id_prestasi',
                'organisasi' => 'id_organisasi_mhs',
                'sertifikat' => 'id_sertifikat',
                'magang' => 'id_magang',
            }, $id)->first(['id_mahasiswa']);
            if ($item) {
                $this->flushRelatedCaches($item->id_mahasiswa);
            }
        }
    }

    public function baakApproveGrupA(string $type, $id, User $user): void
    {
        $item = $this->resolveGrupA($type, $id);
        if ($item->status !== 'pending') {
            throw new \RuntimeException("Item ini sudah diproses.");
        }

        DB::transaction(function () use ($item, $user, $type, $id) {
            $item->update([
                'approved_by' => $user->id_user,
                'approved_at' => now(),
                'keterangan' => null,
                'status' => 'approved',
            ]);

            Approval::create([
                'approvable_type' => $this->getMorphType($type),
                'approvable_id' => $id,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'approved',
                'notes' => null,
            ]);
        });

        $this->flushByItem($type, $id);
    }

    public function baakRejectGrupA(string $type, $id, string $reason, User $user): void
    {
        $item = $this->resolveGrupA($type, $id);
        if ($item->status !== 'pending') {
            throw new \RuntimeException("Item ini sudah diproses.");
        }

        DB::transaction(function () use ($item, $user, $reason, $type, $id) {
            $item->update([
                'approved_by' => $user->id_user,
                'approved_at' => now(),
                'status' => 'rejected',
                'keterangan' => $reason,
            ]);

            Approval::create([
                'approvable_type' => $this->getMorphType($type),
                'approvable_id' => $id,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'rejected',
                'notes' => $reason,
            ]);
        });

        $this->flushByItem($type, $id);
    }

    public function baakApproveTugasAkhir($id, User $user): void
    {
        $item = TugasAkhir::findOrFail($id);
        if ($item->status !== 'pending' && $item->status !== null) {
            throw new \RuntimeException("Tugas Akhir sudah diproses.");
        }

        DB::transaction(function () use ($item, $user, $id) {
            $item->update([
                'approved_by' => $user->id_user,
                'approved_at' => now(),
                'status' => 'approved',
                'keterangan' => null,
            ]);

            Approval::create([
                'approvable_type' => 'tugas_akhir',
                'approvable_id' => $id,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'approved',
            ]);
        });

        $this->flushRelatedCaches($item->id_mahasiswa);
    }

    public function baakRejectTugasAkhir($id, string $reason, User $user): void
    {
        $item = TugasAkhir::findOrFail($id);
        if ($item->status !== 'pending' && $item->status !== null) {
            throw new \RuntimeException("Tugas Akhir sudah diproses.");
        }

        DB::transaction(function () use ($item, $user, $reason, $id) {
            $item->update([
                'approved_by' => $user->id_user,
                'approved_at' => now(),
                'status' => 'rejected',
                'keterangan' => $reason,
            ]);

            Approval::create([
                'approvable_type' => 'tugas_akhir',
                'approvable_id' => $id,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'rejected',
                'notes' => $reason,
            ]);
        });

        $this->flushRelatedCaches($item->id_mahasiswa);
    }

    public function baakApprovePengajuanCetak($idPengajuan, User $user): void
    {
        $pengajuan = PengajuanSkpi::findOrFail($idPengajuan);
        if ($pengajuan->status !== 'diajukan') {
            throw new \RuntimeException("Pengajuan cetak tidak dalam status yang tepat.");
        }

        DB::transaction(function () use ($pengajuan, $user, $idPengajuan) {
            $pengajuan->update([
                'diverifikasi_oleh' => $user->id_user,
                'tanggal_verifikasi' => now(),
                'status' => 'verifikasi',
            ]);

            Approval::create([
                'approvable_type' => 'pengajuan_skpi',
                'approvable_id' => $idPengajuan,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'approved',
            ]);
        });

        $this->flushRelatedCaches($pengajuan->id_mahasiswa, $idPengajuan);
    }

    public function baakRejectPengajuanCetak($idPengajuan, string $reason, User $user): void
    {
        $pengajuan = PengajuanSkpi::findOrFail($idPengajuan);
        if ($pengajuan->status !== 'diajukan') {
            throw new \RuntimeException("Pengajuan cetak tidak dalam status yang tepat.");
        }

        DB::transaction(function () use ($pengajuan, $user, $reason, $idPengajuan) {
            $pengajuan->update([
                'diverifikasi_oleh' => $user->id_user,
                'tanggal_verifikasi' => now(),
                'catatan_bak' => $reason,
                'status' => 'ditolak',
            ]);

            Approval::create([
                'approvable_type' => 'pengajuan_skpi',
                'approvable_id' => $idPengajuan,
                'role' => 'baak',
                'user_id' => $user->id_user,
                'status' => 'rejected',
                'notes' => $reason,
            ]);
        });

        $this->flushRelatedCaches($pengajuan->id_mahasiswa, $idPengajuan);
    }

    private function resolveGrupA(string $type, $id): mixed
    {
        return match ($type) {
            'prestasi' => PrestasiMahasiswa::findOrFail($id),
            'organisasi' => OrganisasiMahasiswa::findOrFail($id),
            'sertifikat' => SertifikatMahasiswa::findOrFail($id),
            'magang' => MagangMahasiswa::findOrFail($id),
            default => throw new \InvalidArgumentException("Kategori tidak valid: $type"),
        };
    }

    private function getMorphType(string $type): string
    {
        return match ($type) {
            'prestasi' => 'prestasi',
            'organisasi' => 'organisasi',
            'sertifikat' => 'sertifikat',
            'magang' => 'magang',
            default => $type,
        };
    }
}
