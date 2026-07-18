<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('organisasi_mahasiswa')) return;

        Schema::create('organisasi_mahasiswa', function (Blueprint $table) {
            $table->increments('id_organisasi_mhs');
            $table->char('nim', 10);
            $table->string('nama_organisasi', 255);
            $table->enum('tingkat', ['Internasional', 'Nasional', 'Universitas', 'Fakultas']);
            $table->string('jabatan', 100)->nullable();
            $table->year('tahun_mulai')->nullable();
            $table->year('tahun_selesai')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_bukti', 255)->nullable();
            $table->integer('approved_by')->unsigned()->nullable()->comment('FK users (role: bak_fakultas)');
            $table->datetime('approved_at')->nullable();
            $table->text('keterangan')->nullable();

            $table->index('nim', 'idx_organisasi_mahasiswa');
            $table->index('status', 'idx_organisasi_status');
            $table->index('approved_by', 'idx_organisasi_approved_by');
            $table->index(['nim', 'status'], 'idx_organisasi_mhs_status');
            $table->foreign('nim', 'fk_organisasi_mahasiswa')
                ->references('nim')->on('mahasiswa')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approved_by', 'fk_organisasi_approved_by')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organisasi_mahasiswa');
    }
};
