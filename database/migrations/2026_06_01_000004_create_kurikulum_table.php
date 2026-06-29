<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kurikulum')) return;

        Schema::create('kurikulum', function (Blueprint $table) {
            $table->smallIncrements('id_kurikulum');
            $table->string('id_prodi', 50);
            $table->string('nama_kurikulum', 255);
            $table->year('tahun');
            $table->timestamps();

            $table->index('id_prodi', 'idx_kurikulum_prodi');
            $table->foreign('id_prodi', 'fk_kurikulum_prodi')
                ->references('id_prodi')->on('program_studi')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kurikulum');
    }
};
