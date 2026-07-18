<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sertifikat_mahasiswa')) return;

        Schema::create('sertifikat_mahasiswa', function (Blueprint $table) {
            $table->increments('id_sertifikat');
            $table->char('nim', 10);
            $table->string('nama_sertifikat', 255);
            $table->enum('jenis_sertifikat', ['Keagamaan', 'Teknis', 'Bahasa', 'Profesional']);
            $table->string('bidang', 100)->nullable();
            $table->string('penyelenggara', 255)->nullable();
            $table->date('tanggal_terbit')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_bukti', 255)->nullable();
            $table->integer('approved_by')->unsigned()->nullable()->comment('FK users (role: bak_fakultas)');
            $table->datetime('approved_at')->nullable();
            $table->text('keterangan')->nullable();

            $table->index('nim', 'idx_sertifikat_mahasiswa');
            $table->index('status', 'idx_sertifikat_status');
            $table->index('approved_by', 'idx_sertifikat_approved_by');
            $table->index(['nim', 'status'], 'idx_sertifikat_mhs_status');
            $table->foreign('nim', 'fk_sertifikat_mahasiswa')
                ->references('nim')->on('mahasiswa')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approved_by', 'fk_sertifikat_approved_by')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sertifikat_mahasiswa');
    }
};
