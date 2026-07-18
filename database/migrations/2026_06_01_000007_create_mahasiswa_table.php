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
            $table->char('nim', 10)->primary();
            $table->string('id_prodi', 36);
            $table->char('id_kurikulum', 7);
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

            $table->index('id_prodi', 'idx_mahasiswa_prodi');
            $table->index('id_kurikulum', 'idx_mahasiswa_kurikulum');
            $table->index('status', 'idx_mahasiswa_status');
            $table->foreign('id_prodi', 'fk_mahasiswa_prodi')
                ->references('id_prodi')->on('program_studi')
                ->onUpdate('cascade');
            $table->foreign('id_kurikulum', 'fk_mahasiswa_kurikulum')
                ->references('id_kurikulum')->on('kurikulum')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mahasiswa');
    }
};
