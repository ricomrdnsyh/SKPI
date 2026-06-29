<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('users')) return;

        Schema::create('users', function (Blueprint $table) {
            $table->increments('id_user');
            $table->string('username', 100);
            $table->string('nama_lengkap', 255);
            $table->enum('role', ['admin', 'bak_fakultas']);
            $table->string('id_prodi', 50)->nullable()->comment('Diisi untuk role bak_fakultas dan kaprodi');
            $table->string('email', 100)->nullable();
            $table->string('password', 255);
            $table->boolean('aktif')->default(true);
            $table->timestamp('created_at')->useCurrent();

            $table->unique('username', 'uq_users_username');
            $table->unique('email', 'uq_users_email');
            $table->index('id_prodi', 'idx_users_prodi');
            $table->index('role', 'idx_users_role');
            $table->foreign('id_prodi', 'fk_users_prodi')
                ->references('id_prodi')->on('program_studi')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
