<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pengajuan_skpi')) return;

        Schema::create('pengajuan_skpi', function (Blueprint $table) {
            $table->increments('id_pengajuan');
            $table->integer('id_mahasiswa')->unsigned();
            $table->datetime('tanggal_pengajuan')->useCurrent()->comment('Tanggal mahasiswa mengajukan SKPI');
            $table->enum('status', ['draft', 'diajukan', 'verifikasi', 'dicetak', 'ditolak'])->default('draft');
            $table->text('catatan_mahasiswa')->nullable()->comment('Keterangan tambahan dari mahasiswa saat pengajuan');
            $table->integer('diverifikasi_oleh')->unsigned()->nullable()->comment('FK users (role: bak_fakultas)');
            $table->datetime('tanggal_verifikasi')->nullable();
            $table->text('catatan_bak')->nullable()->comment('Catatan hasil verifikasi dari BAK Fakultas');
            $table->datetime('tanggal_disposisi')->nullable();
            $table->boolean('permohonan_cetak')->default(false);
            $table->timestamps();

            $table->index('id_mahasiswa', 'idx_pengajuan_mahasiswa');
            $table->index('status', 'idx_pengajuan_status');
            $table->index('diverifikasi_oleh', 'idx_pengajuan_verifikasi_oleh');
            $table->index(['id_mahasiswa', 'status'], 'idx_pengajuan_mhs_status');
            $table->index(['permohonan_cetak', 'status'], 'idx_pengajuan_permohonan');
            $table->foreign('id_mahasiswa', 'fk_pengajuan_mahasiswa')
                ->references('id_mahasiswa')->on('mahasiswa')
                ->onUpdate('cascade');
            $table->foreign('diverifikasi_oleh', 'fk_pengajuan_verifikasi_oleh')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pengajuan_skpi');
    }
};
