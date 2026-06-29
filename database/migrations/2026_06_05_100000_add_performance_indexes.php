<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // fakultas
        if (!Schema::hasIndex('fakultas', 'idx_fakultas_kode')) {
            Schema::table('fakultas', function (Blueprint $table) {
                $table->index('kode_fakultas', 'idx_fakultas_kode');
            });
        }

        // program_studi
        if (!Schema::hasIndex('program_studi', 'idx_prodi_fakultas')) {
            Schema::table('program_studi', function (Blueprint $table) {
                $table->index('id_fakultas', 'idx_prodi_fakultas');
            });
        }

        // mahasiswa
        if (!Schema::hasIndex('mahasiswa', 'idx_mahasiswa_prodi')) {
            Schema::table('mahasiswa', function (Blueprint $table) {
                $table->index('id_prodi', 'idx_mahasiswa_prodi');
                $table->index('id_kurikulum', 'idx_mahasiswa_kurikulum');
                $table->index('id_dosen_wali', 'idx_mahasiswa_dosen_wali');
                $table->index('status', 'idx_mahasiswa_status');
            });
        }

        // prestasi_mahasiswa
        if (!Schema::hasIndex('prestasi_mahasiswa', 'idx_prestasi_mahasiswa')) {
            Schema::table('prestasi_mahasiswa', function (Blueprint $table) {
                $table->index('id_mahasiswa', 'idx_prestasi_mahasiswa');
                $table->index('status', 'idx_prestasi_status');
                $table->index('approved_by', 'idx_prestasi_approved_by');
                $table->index(['id_mahasiswa', 'status'], 'idx_prestasi_mhs_status');
            });
        }

        // organisasi_mahasiswa
        if (!Schema::hasIndex('organisasi_mahasiswa', 'idx_organisasi_mahasiswa')) {
            Schema::table('organisasi_mahasiswa', function (Blueprint $table) {
                $table->index('id_mahasiswa', 'idx_organisasi_mahasiswa');
                $table->index('status', 'idx_organisasi_status');
                $table->index('approved_by', 'idx_organisasi_approved_by');
                $table->index(['id_mahasiswa', 'status'], 'idx_organisasi_mhs_status');
            });
        }

        // sertifikat_mahasiswa
        if (!Schema::hasIndex('sertifikat_mahasiswa', 'idx_sertifikat_mahasiswa')) {
            Schema::table('sertifikat_mahasiswa', function (Blueprint $table) {
                $table->index('id_mahasiswa', 'idx_sertifikat_mahasiswa');
                $table->index('status', 'idx_sertifikat_status');
                $table->index('approved_by', 'idx_sertifikat_approved_by');
                $table->index(['id_mahasiswa', 'status'], 'idx_sertifikat_mhs_status');
            });
        }

        // magang_mahasiswa
        if (!Schema::hasIndex('magang_mahasiswa', 'idx_magang_mahasiswa')) {
            Schema::table('magang_mahasiswa', function (Blueprint $table) {
                $table->index('id_mahasiswa', 'idx_magang_mahasiswa');
                $table->index('id_tempat_magang', 'idx_magang_tempat');
                $table->index('status', 'idx_magang_status');
                $table->index('approved_by', 'idx_magang_approved_by');
                $table->index(['id_mahasiswa', 'status'], 'idx_magang_mhs_status');
            });
        }

        // tugas_akhir
        if (!Schema::hasIndex('tugas_akhir', 'idx_ta_mhs_status')) {
            Schema::table('tugas_akhir', function (Blueprint $table) {
                $table->index(['id_mahasiswa', 'status'], 'idx_ta_mhs_status');
            });
        }

        // pengajuan_skpi
        if (!Schema::hasIndex('pengajuan_skpi', 'idx_pengajuan_mahasiswa')) {
            Schema::table('pengajuan_skpi', function (Blueprint $table) {
                $table->index('id_mahasiswa', 'idx_pengajuan_mahasiswa');
                $table->index('status', 'idx_pengajuan_status');
                $table->index('diverifikasi_oleh', 'idx_pengajuan_verifikasi_oleh');
                $table->index(['id_mahasiswa', 'status'], 'idx_pengajuan_mhs_status');
                $table->index(['permohonan_cetak', 'status'], 'idx_pengajuan_permohonan');
            });
        }

        // approvals
        if (!Schema::hasIndex('approvals', 'idx_approvals_approvable')) {
            Schema::table('approvals', function (Blueprint $table) {
                $table->index(['approvable_type', 'approvable_id'], 'idx_approvals_approvable');
                $table->index('role', 'idx_approvals_role');
                $table->index('user_id', 'idx_approvals_user');
            });
        }

        // kurikulum
        if (!Schema::hasIndex('kurikulum', 'idx_kurikulum_prodi')) {
            Schema::table('kurikulum', function (Blueprint $table) {
                $table->index('id_prodi', 'idx_kurikulum_prodi');
            });
        }

        // cpl_prodi
        if (!Schema::hasIndex('cpl_prodi', 'idx_cpl_prodi')) {
            Schema::table('cpl_prodi', function (Blueprint $table) {
                $table->index('id_prodi', 'idx_cpl_prodi');
                $table->index('id_kategori', 'idx_cpl_kategori');
                $table->index('id_kurikulum', 'idx_cpl_kurikulum');
            });
        }

        // users
        if (!Schema::hasIndex('users', 'idx_users_prodi')) {
            Schema::table('users', function (Blueprint $table) {
                $table->index('id_prodi', 'idx_users_prodi');
                $table->index('role', 'idx_users_role');
            });
        }

        // dosen
        if (!Schema::hasIndex('dosen', 'idx_dosen_prodi')) {
            Schema::table('dosen', function (Blueprint $table) {
                $table->index('id_prodi', 'idx_dosen_prodi');
            });
        }

        // pembimbing_tugas_akhir
        if (!Schema::hasIndex('pembimbing_tugas_akhir', 'idx_pembimbing_ta')) {
            Schema::table('pembimbing_tugas_akhir', function (Blueprint $table) {
                $table->index('id_tugas_akhir', 'idx_pembimbing_ta');
                $table->index('id_dosen', 'idx_pembimbing_dosen');
            });
        }

        // skpi
        if (!Schema::hasIndex('skpi', 'idx_skpi_pengajuan')) {
            Schema::table('skpi', function (Blueprint $table) {
                $table->index('id_pengajuan', 'idx_skpi_pengajuan');
                $table->index('dicetak_oleh', 'idx_skpi_dicetak_oleh');
            });
        }

        // checklist_verifikasi_skpi
        if (!Schema::hasIndex('checklist_verifikasi_skpi', 'idx_checklist_verifikasi_oleh')) {
            Schema::table('checklist_verifikasi_skpi', function (Blueprint $table) {
                $table->index('diverifikasi_oleh', 'idx_checklist_verifikasi_oleh');
            });
        }
    }

    public function down(): void
    {
        // Tidak perlu di-reverse karena index tidak mengganggu data
    }
};
