<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('magang_mahasiswa', function (Blueprint $table) {
            // Drop foreign key and column id_tempat_magang
            if (Schema::hasColumn('magang_mahasiswa', 'id_tempat_magang')) {
                $table->dropForeign('fk_magang_tempat');
                $table->dropColumn('id_tempat_magang');
            }
            // Add tempat_magang string column
            if (!Schema::hasColumn('magang_mahasiswa', 'tempat_magang')) {
                $table->string('tempat_magang', 255)->nullable()->after('id_mahasiswa');
            }
        });

        // Drop tempat_magang table
        Schema::dropIfExists('tempat_magang');
    }

    public function down(): void
    {
        // Re-create tempat_magang table
        if (!Schema::hasTable('tempat_magang')) {
            Schema::create('tempat_magang', function (Blueprint $table) {
                $table->smallIncrements('id_tempat_magang');
                $table->string('nama_perusahaan', 150);
                $table->string('alamat', 255)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('telepon', 20)->nullable();
            });
        }

        Schema::table('magang_mahasiswa', function (Blueprint $table) {
            if (!Schema::hasColumn('magang_mahasiswa', 'id_tempat_magang')) {
                $table->smallInteger('id_tempat_magang')->unsigned()->nullable()->after('id_mahasiswa');
                $table->foreign('id_tempat_magang', 'fk_magang_tempat')
                    ->references('id_tempat_magang')->on('tempat_magang')
                    ->onDelete('set null')->onUpdate('cascade');
            }
            if (Schema::hasColumn('magang_mahasiswa', 'tempat_magang')) {
                $table->dropColumn('tempat_magang');
            }
        });
    }
};
