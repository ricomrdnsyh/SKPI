<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('program_studi')) return;

        Schema::create('program_studi', function (Blueprint $table) {
            $table->string('id_prodi', 50)->primary();
            $table->tinyInteger('id_fakultas')->unsigned();
            $table->string('nama_prodi', 255);
            $table->string('kode_prodi', 10)->nullable();
            $table->enum('jenjang', ['D3', 'S1', 'S2', 'S3']);
            $table->string('gelar', 50)->nullable();
            $table->string('sk_akreditasi', 100)->nullable();
            $table->date('tanggal_sk_akreditasi')->nullable();
            $table->date('masa_berlaku_akreditasi')->nullable();
            $table->string('jenjang_kkni', 10)->nullable();
            $table->string('bahasa_pengantar', 50)->default('Indonesia');
            $table->string('lama_studi', 50)->nullable();
            $table->string('jenis_pendidikan', 100)->nullable();
            $table->string('jenis_pendidikan_lanjutan', 100)->nullable();
            $table->text('persyaratan_penerimaan')->nullable();
            $table->text('alamat_prodi')->nullable();
            $table->string('telepon_prodi', 20)->nullable();
            $table->string('email_prodi', 100)->nullable();
            $table->string('password', 255)->nullable();
            $table->string('status', 20)->default('active');

            $table->index('id_fakultas', 'idx_prodi_fakultas');
            $table->foreign('id_fakultas', 'fk_prodi_fakultas')
                ->references('id_fakultas')->on('fakultas')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
