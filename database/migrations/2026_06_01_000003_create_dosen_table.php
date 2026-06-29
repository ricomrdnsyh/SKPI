<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('dosen')) return;

        Schema::create('dosen', function (Blueprint $table) {
            $table->smallIncrements('id_dosen');
            $table->string('nidn', 20)->nullable();
            $table->string('gelar_depan', 50)->nullable();
            $table->string('nama_dosen', 255);
            $table->string('gelar_belakang', 50)->nullable();
            $table->string('id_prodi', 50)->nullable();

            $table->unique('nidn', 'uq_dosen_niy');
            $table->index('id_prodi', 'idx_dosen_prodi');
            $table->foreign('id_prodi', 'fk_dosen_prodi')
                ->references('id_prodi')->on('program_studi')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dosen');
    }
};
