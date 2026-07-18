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
            $table->string('id_tahun_akademik', 20)->nullable()->after('nim');
            $table->foreign('id_tahun_akademik')->references('id_tahun_akademik')->on('tahun_akademik')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pengajuan_skpi', function (Blueprint $table) {
            $table->dropForeign(['id_tahun_akademik']);
            $table->dropColumn('id_tahun_akademik');
        });
    }
};
