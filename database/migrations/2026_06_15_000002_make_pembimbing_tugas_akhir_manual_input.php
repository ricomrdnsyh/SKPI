<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Add nama_dosen as nullable first so we can migrate existing data
        Schema::table('pembimbing_tugas_akhir', function (Blueprint $table) {
            $table->string('nama_dosen', 255)->nullable()->after('id_dosen');
        });

        // 2. Migrate existing data from dosen table if the table exists
        if (Schema::hasTable('dosen')) {
            $pembimbingRecords = DB::table('pembimbing_tugas_akhir')
                ->join('dosen', 'pembimbing_tugas_akhir.id_dosen', '=', 'dosen.id_dosen')
                ->select('pembimbing_tugas_akhir.id_pembimbing_ta', 'dosen.nama_dosen', 'dosen.gelar_depan', 'dosen.gelar_belakang')
                ->get();

            foreach ($pembimbingRecords as $p) {
                $fullName = trim(
                    ($p->gelar_depan ? $p->gelar_depan . ' ' : '') .
                    $p->nama_dosen .
                    ($p->gelar_belakang ? ', ' . $p->gelar_belakang : '')
                );
                DB::table('pembimbing_tugas_akhir')
                    ->where('id_pembimbing_ta', $p->id_pembimbing_ta)
                    ->update(['nama_dosen' => $fullName]);
            }
        }

        // 3. Drop foreign key, drop index, drop column id_dosen, and make nama_dosen not nullable
        Schema::table('pembimbing_tugas_akhir', function (Blueprint $table) {
            $table->dropForeign('fk_pembimbing_dosen');
            $table->dropColumn('id_dosen');
            $table->string('nama_dosen', 255)->nullable(false)->change();
        });

        // 4. Drop the dosen table completely
        Schema::dropIfExists('dosen');
    }

    public function down(): void
    {
        // Recreate the dosen table
        Schema::create('dosen', function (Blueprint $table) {
            $table->smallIncrements('id_dosen');
            $table->string('nidn', 30)->unique();
            $table->string('nama_dosen', 150);
            $table->string('gelar_depan', 30)->nullable();
            $table->string('gelar_belakang', 30)->nullable();
            $table->integer('id_prodi')->unsigned();
        });

        // Re-add id_dosen column and foreign key on pembimbing_tugas_akhir
        Schema::table('pembimbing_tugas_akhir', function (Blueprint $table) {
            $table->smallInteger('id_dosen')->unsigned()->nullable()->after('id_tugas_akhir');
            $table->index('id_dosen', 'idx_pembimbing_dosen');
            $table->foreign('id_dosen', 'fk_pembimbing_dosen')
                ->references('id_dosen')->on('dosen')
                ->onUpdate('cascade');
        });

        // Copy manual input names as temporary data to dosen table if possible
        $pembimbingManual = DB::table('pembimbing_tugas_akhir')->get();
        foreach ($pembimbingManual as $index => $p) {
            $nidn = 'NIDN_' . str_pad($index + 1, 6, '0', STR_PAD_LEFT);
            $idDosen = DB::table('dosen')->insertGetId([
                'nidn' => $nidn,
                'nama_dosen' => $p->nama_dosen,
                'id_prodi' => 1 // dummy/fallback
            ]);

            DB::table('pembimbing_tugas_akhir')
                ->where('id_pembimbing_ta', $p->id_pembimbing_ta)
                ->update(['id_dosen' => $idDosen]);
        }

        // Drop the nama_dosen column
        Schema::table('pembimbing_tugas_akhir', function (Blueprint $table) {
            $table->smallInteger('id_dosen')->unsigned()->nullable(false)->change();
            $table->dropColumn('nama_dosen');
        });
    }
};
