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
        Schema::table('pengajuan_skpi', function (Blueprint $table) {
            $table->string('sk_akreditasi')->nullable();
            $table->json('sistem_penilaian')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_skpi', function (Blueprint $table) {
            $table->dropColumn(['sk_akreditasi', 'sistem_penilaian']);
        });
    }
};
