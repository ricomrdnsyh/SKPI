<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('magang_mahasiswa')) return;

        Schema::create('magang_mahasiswa', function (Blueprint $table) {
            $table->increments('id_magang');
            $table->char('nim', 10);
            $table->smallInteger('id_tempat_magang')->unsigned()->nullable();
            $table->string('posisi', 100)->nullable();
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_selesai')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('file_bukti', 255)->nullable();
            $table->integer('approved_by')->unsigned()->nullable()->comment('FK users (role: bak_fakultas)');
            $table->datetime('approved_at')->nullable();
            $table->text('keterangan')->nullable();

            $table->index('nim', 'idx_magang_mahasiswa');
            $table->index('id_tempat_magang', 'idx_magang_tempat');
            $table->index('status', 'idx_magang_status');
            $table->index('approved_by', 'idx_magang_approved_by');
            $table->index(['nim', 'status'], 'idx_magang_mhs_status');
            $table->foreign('nim', 'fk_magang_mahasiswa')
                ->references('nim')->on('mahasiswa')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_tempat_magang', 'fk_magang_tempat')
                ->references('id_tempat_magang')->on('tempat_magang')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('approved_by', 'fk_magang_approved_by')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('magang_mahasiswa');
    }
};
