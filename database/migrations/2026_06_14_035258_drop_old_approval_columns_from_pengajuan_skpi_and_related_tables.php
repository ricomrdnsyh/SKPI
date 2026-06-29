<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $this->dropPengajuanSkpiCols();
        $this->dropItemDwCols('prestasi_mahasiswa', 'fk_prestasi_mahasiswa_approved_by_dosen_wali');
        $this->dropItemDwCols('organisasi_mahasiswa', 'fk_organisasi_mahasiswa_approved_by_dosen_wali');
        $this->dropItemDwCols('sertifikat_mahasiswa', 'fk_sertifikat_mahasiswa_approved_by_dosen_wali');
        $this->dropItemDwCols('magang_mahasiswa', 'fk_magang_mahasiswa_approved_by_dosen_wali');
        $this->dropTugasAkhirCols();
    }

    private function dropPengajuanSkpiCols(): void
    {
        if (!Schema::hasColumn('pengajuan_skpi', 'disetujui_dosen_wali')) {
            return;
        }

        Schema::table('pengajuan_skpi', function (Blueprint $table) {
            $table->dropForeign('fk_pengajuan_dosen_wali');
            $table->dropForeign('fk_pengajuan_kaprodi');
            $table->dropForeign('fk_pengajuan_dekan');
            $table->dropColumn([
                'disetujui_dosen_wali', 'tanggal_persetujuan_dosen_wali', 'catatan_dosen_wali',
                'disetujui_kaprodi', 'tanggal_persetujuan_kaprodi', 'catatan_kaprodi',
                'disetujui_dekan', 'tanggal_persetujuan_dekan', 'catatan_dekan',
            ]);
        });
    }

    private function dropItemDwCols(string $table, string $fkName): void
    {
        if (!Schema::hasColumn($table, 'approved_by_dosen_wali')) {
            return;
        }

        Schema::table($table, function (Blueprint $table) use ($fkName) {
            $table->dropForeign($fkName);
            $table->dropColumn(['approved_by_dosen_wali', 'approved_by_dosen_wali_at']);
        });
    }

    private function dropTugasAkhirCols(): void
    {
        if (!Schema::hasColumn('tugas_akhir', 'approved_by_dosen_wali')) {
            return;
        }

        Schema::table('tugas_akhir', function (Blueprint $table) {
            $table->dropForeign('fk_ta_approved_by_dosen_wali');
            $table->dropForeign('fk_ta_approved_by_kaprodi');
            $table->dropColumn(['approved_by_dosen_wali', 'approved_by_kaprodi']);
        });
    }

    public function down(): void
    {
        // Kolom sudah tidak dipakai kode
    }
};
