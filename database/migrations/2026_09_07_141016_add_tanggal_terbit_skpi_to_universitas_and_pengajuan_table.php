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
        Schema::table('universitas', function (Blueprint $table) {
            $table->date('tanggal_terbit_skpi')->nullable()->after('no_telepon');
        });

        Schema::table('pengajuan_skpi', function (Blueprint $table) {
            $table->date('tanggal_terbit_skpi')->nullable()->after('sistem_penilaian');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('universitas', function (Blueprint $table) {
            $table->dropColumn('tanggal_terbit_skpi');
        });

        Schema::table('pengajuan_skpi', function (Blueprint $table) {
            $table->dropColumn('tanggal_terbit_skpi');
        });
    }
};
