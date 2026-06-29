<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('prestasi_mahasiswa')) return;

        Schema::create('prestasi_mahasiswa', function (Blueprint $table) {
            $table->increments('id_prestasi');
            $table->integer('id_mahasiswa')->unsigned();
            $table->string('nama_prestasi', 255);
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Provinsi', 'Lokal']);
            $table->string('peringkat', 50)->nullable();
            $table->string('penyelenggara', 255)->nullable();
            $table->year('tahun')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_bukti', 255)->nullable();
            $table->integer('approved_by')->unsigned()->nullable()->comment('FK users (role: bak_fakultas)');
            $table->datetime('approved_at')->nullable();
            $table->text('keterangan')->nullable();

            $table->index('id_mahasiswa', 'idx_prestasi_mahasiswa');
            $table->index('status', 'idx_prestasi_status');
            $table->index('approved_by', 'idx_prestasi_approved_by');
            $table->index(['id_mahasiswa', 'status'], 'idx_prestasi_mhs_status');
            $table->foreign('id_mahasiswa', 'fk_prestasi_mahasiswa')
                ->references('id_mahasiswa')->on('mahasiswa')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approved_by', 'fk_prestasi_approved_by')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prestasi_mahasiswa');
    }
};
