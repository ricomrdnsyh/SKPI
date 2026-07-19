<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dosen', function (Blueprint $table) {
            $table->char('id_penduduk', 10)->primary();
            $table->string('nidn', 12)->nullable();
            $table->string('nama_dosen', 100);
            $table->enum('jenis_kelamin', ['L', 'P'])->nullable();
            $table->string('email', 100)->nullable();
            $table->string('no_hp', 15)->nullable();
            $table->tinyInteger('id_fakultas')->unsigned()->nullable();
            $table->string('id_prodi', 50)->nullable();
            $table->timestamps();

            $table->foreign('id_fakultas')->references('id_fakultas')->on('fakultas')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('id_prodi')->references('id_prodi')->on('program_studi')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
