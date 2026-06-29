<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tempat_magang')) return;

        Schema::create('tempat_magang', function (Blueprint $table) {
            $table->smallIncrements('id_tempat_magang');
            $table->string('nama_perusahaan', 255);
            $table->string('bidang_usaha', 100)->nullable();
            $table->text('alamat')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tempat_magang');
    }
};
