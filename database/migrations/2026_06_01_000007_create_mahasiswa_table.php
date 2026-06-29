<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mahasiswa')) return;

        Schema::create('mahasiswa', function (Blueprint $table) {
            $table->increments('id_mahasiswa');
            $table->string('nim', 20);
            $table->string('id_prodi', 50);
            $table->smallInteger('id_kurikulum')->unsigned();
            $table->smallInteger('id_dosen_wali')->unsigned()->nullable();
            $table->string('nama_lengkap', 255);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->year('tahun_masuk')->nullable();
            $table->year('tahun_lulus')->nullable();
            $table->date('tanggal_lulus')->nullable();
            $table->enum('status', ['Aktif', 'Lulus'])->default('Aktif');
            $table->decimal('ipk', 4, 2)->nullable();
            $table->string('foto', 255)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('nomor_telepon', 20)->nullable();
            $table->string('password', 255)->nullable();

            $table->unique('nim', 'uq_mahasiswa_nim');
            $table->index('id_prodi', 'idx_mahasiswa_prodi');
            $table->index('id_kurikulum', 'idx_mahasiswa_kurikulum');
            $table->index('id_dosen_wali', 'idx_mahasiswa_dosen_wali');
            $table->index('status', 'idx_mahasiswa_status');
            $table->foreign('id_prodi', 'fk_mahasiswa_prodi')
                ->references('id_prodi')->on('program_studi')
                ->onUpdate('cascade');
            $table->foreign('id_kurikulum', 'fk_mahasiswa_kurikulum')
                ->references('id_kurikulum')->on('kurikulum')
                ->onUpdate('cascade');
            $table->foreign('id_dosen_wali', 'fk_mahasiswa_dosen_wali')
                ->references('id_dosen')->on('dosen')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
