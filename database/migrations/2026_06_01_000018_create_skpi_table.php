<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('skpi')) return;

        Schema::create('skpi', function (Blueprint $table) {
            $table->increments('id_skpi');
            $table->string('nomor_skpi', 100);
            $table->char('nim', 10);
            $table->integer('id_pengajuan')->unsigned()->nullable()->comment('Relasi ke tabel pengajuan_skpi');
            $table->string('nim_ijazah', 50);
            $table->date('tanggal_terbit')->comment('Tanggal SKPI diterbitkan oleh BAAK Fakultas');
            $table->integer('dicetak_oleh')->unsigned()->nullable()->comment('FK users (role: bak_fakultas)');
            $table->text('status_profesi')->nullable();
            $table->date('tanggal_ttd_dekan')->nullable()->comment('Tanggal ditandatangani oleh Dekan');
            $table->string('ditandatangani_oleh', 100)->nullable()->comment('Nama Dekan saat TTD (historis, bisa berbeda dari data fakultas)');
            $table->string('niy_penandatangan', 50)->nullable()->comment('NIY/NIDN Dekan saat TTD');

            $table->unique('nomor_skpi', 'uq_skpi_nomor');
            $table->unique('nim', 'uq_skpi_mahasiswa');
            $table->index('id_pengajuan', 'idx_skpi_pengajuan');
            $table->index('dicetak_oleh', 'idx_skpi_dicetak_oleh');
            $table->foreign('nim', 'fk_skpi_mahasiswa')
                ->references('nim')->on('mahasiswa')
                ->onUpdate('cascade');
            $table->foreign('id_pengajuan', 'fk_skpi_pengajuan')
                ->references('id_pengajuan')->on('pengajuan_skpi')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('dicetak_oleh', 'fk_skpi_dicetak_oleh')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('skpi');
    }
};
