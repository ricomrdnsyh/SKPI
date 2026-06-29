<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->dropForeign('fk_mahasiswa_dosen_wali');
            $table->dropIndex('idx_mahasiswa_dosen_wali');
            $table->dropColumn('id_dosen_wali');
        });
    }

    public function down(): void
    {
        Schema::table('mahasiswa', function (Blueprint $table) {
            $table->smallInteger('id_dosen_wali')->unsigned()->nullable();
            $table->index('id_dosen_wali', 'idx_mahasiswa_dosen_wali');
            $table->foreign('id_dosen_wali', 'fk_mahasiswa_dosen_wali')
                ->references('id_dosen')->on('dosen')
                ->onDelete('set null')
                ->onUpdate('cascade');
        });
    }
};
