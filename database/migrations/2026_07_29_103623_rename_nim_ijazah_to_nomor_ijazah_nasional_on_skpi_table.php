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
        Schema::table('skpi', function (Blueprint $table) {
            $table->renameColumn('nim_ijazah', 'nomor_ijazah_nasional');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('skpi', function (Blueprint $table) {
            $table->renameColumn('nomor_ijazah_nasional', 'nim_ijazah');
        });
    }
};
