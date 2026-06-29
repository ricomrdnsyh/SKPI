<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('sistem_penilaian')) return;

        Schema::create('sistem_penilaian', function (Blueprint $table) {
            $table->smallIncrements('id_penilaian');
            $table->string('nilai_huruf', 5);
            $table->decimal('nilai_min', 5, 2)->nullable();
            $table->decimal('nilai_max', 5, 2)->nullable();

            $table->unique('nilai_huruf', 'uq_penilaian_nilai_huruf');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sistem_penilaian');
    }
};
