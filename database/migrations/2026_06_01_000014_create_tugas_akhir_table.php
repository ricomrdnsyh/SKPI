<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('tugas_akhir')) return;

        Schema::create('tugas_akhir', function (Blueprint $table) {
            $table->increments('id_tugas_akhir');
            $table->integer('id_mahasiswa')->unsigned();
            $table->text('judul');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->integer('approved_by')->unsigned()->nullable();
            $table->datetime('approved_at')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->unique('id_mahasiswa', 'uq_ta_mahasiswa');
            $table->index('approved_by', 'fk_ta_approved_by');
            $table->index(['id_mahasiswa', 'status'], 'idx_ta_mhs_status');
            $table->foreign('id_mahasiswa', 'fk_ta_mahasiswa')
                ->references('id_mahasiswa')->on('mahasiswa')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('approved_by', 'fk_ta_approved_by')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tugas_akhir');
    }
};
