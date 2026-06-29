<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('cpl_prodi')) return;

        Schema::create('cpl_prodi', function (Blueprint $table) {
            $table->increments('id_cpl');
            $table->string('id_prodi', 50);
            $table->smallInteger('id_kurikulum')->unsigned();
            $table->tinyInteger('id_kategori')->unsigned();
            $table->string('kode_cpl', 20);
            $table->text('deskripsi_cpl');
            $table->smallInteger('urutan')->unsigned()->nullable();

            $table->unique(['id_prodi', 'id_kurikulum', 'kode_cpl'], 'uq_cpl_prodi_kode');
            $table->index('id_prodi', 'idx_cpl_prodi');
            $table->index('id_kategori', 'idx_cpl_kategori');
            $table->index('id_kurikulum', 'idx_cpl_kurikulum');
            $table->foreign('id_prodi', 'fk_cpl_prodi')
                ->references('id_prodi')->on('program_studi')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_kurikulum', 'fk_cpl_kurikulum')
                ->references('id_kurikulum')->on('kurikulum')
                ->onUpdate('cascade');
            $table->foreign('id_kategori', 'fk_cpl_kategori')
                ->references('id_kategori')->on('kategori_cpl')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cpl_prodi');
    }
};
