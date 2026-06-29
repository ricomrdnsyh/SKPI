<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('kategori_cpl')) return;

        Schema::create('kategori_cpl', function (Blueprint $table) {
            $table->tinyIncrements('id_kategori');
            $table->string('kode_kategori', 10);
            $table->string('nama_kategori', 255);
            $table->tinyInteger('urutan')->unsigned()->nullable();

            $table->unique('kode_kategori', 'uq_kategori_kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_cpl');
    }
};
