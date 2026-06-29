<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('checklist_verifikasi_skpi')) return;

        Schema::create('checklist_verifikasi_skpi', function (Blueprint $table) {
            $table->increments('id_checklist');
            $table->integer('id_pengajuan')->unsigned();
            $table->boolean('cek_identitas_mahasiswa')->default(false)->comment('Nama, TTL, NIM, NIM Ijazah');
            $table->boolean('cek_identitas_prodi')->default(false)->comment('SK akreditasi, gelar, jenjang, dll');
            $table->boolean('cek_cpl')->default(false)->comment('Capaian Pembelajaran Lulusan sudah terisi');
            $table->boolean('cek_prestasi')->default(false)->comment('Prestasi/penghargaan sudah diverifikasi');
            $table->boolean('cek_organisasi')->default(false)->comment('Keikutsertaan organisasi sudah diverifikasi');
            $table->boolean('cek_sertifikat')->default(false)->comment('Sertifikat keahlian sudah diverifikasi');
            $table->boolean('cek_magang')->default(false)->comment('Data magang/kerja praktik sudah diverifikasi');
            $table->boolean('cek_tugas_akhir')->default(false)->comment('Judul TA dan nama pembimbing sudah benar');
            $table->boolean('cek_sistem_penilaian')->default(false)->comment('Konversi nilai sudah sesuai');
            $table->enum('hasil_verifikasi', ['lulus', 'perlu_revisi', 'ditolak'])->default('perlu_revisi');
            $table->text('catatan')->nullable()->comment('Catatan khusus dari BAK untuk mahasiswa');
            $table->integer('diverifikasi_oleh')->unsigned();
            $table->datetime('tanggal_verifikasi')->useCurrent();

            $table->unique('id_pengajuan', 'uq_checklist_pengajuan');
            $table->index('diverifikasi_oleh', 'idx_checklist_verifikasi_oleh');
            $table->foreign('id_pengajuan', 'fk_checklist_pengajuan')
                ->references('id_pengajuan')->on('pengajuan_skpi')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('diverifikasi_oleh', 'fk_checklist_verifikasi_oleh')
                ->references('id_user')->on('users')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('checklist_verifikasi_skpi');
    }
};
