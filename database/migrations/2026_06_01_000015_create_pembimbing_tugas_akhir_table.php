<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pembimbing_tugas_akhir')) return;

        Schema::create('pembimbing_tugas_akhir', function (Blueprint $table) {
            $table->increments('id_pembimbing_ta');
            $table->integer('id_tugas_akhir')->unsigned();
            $table->smallInteger('id_dosen')->unsigned();
            $table->tinyInteger('urutan_pembimbing')->unsigned();

            $table->unique(['id_tugas_akhir', 'urutan_pembimbing'], 'uq_pembimbing_ta_urutan');
            $table->index('id_tugas_akhir', 'idx_pembimbing_ta');
            $table->index('id_dosen', 'idx_pembimbing_dosen');
            $table->foreign('id_tugas_akhir', 'fk_pembimbing_ta')
                ->references('id_tugas_akhir')->on('tugas_akhir')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_dosen', 'fk_pembimbing_dosen')
                ->references('id_dosen')->on('dosen')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing_tugas_akhir');
    }
};
