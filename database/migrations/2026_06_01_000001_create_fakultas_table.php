<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('fakultas')) return;

        Schema::create('fakultas', function (Blueprint $table) {
            $table->tinyIncrements('id_fakultas');
            $table->string('nama_fakultas', 255);
            $table->string('kode_fakultas', 10)->nullable();
            $table->string('dekan', 100)->nullable();
            $table->string('nidn_dekan', 50)->nullable();
            $table->string('status', 20)->default('active');

            $table->index('kode_fakultas', 'idx_fakultas_kode');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fakultas');
    }
};
