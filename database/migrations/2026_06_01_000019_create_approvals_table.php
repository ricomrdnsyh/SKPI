<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('approvals')) return;

        Schema::create('approvals', function (Blueprint $table) {
            $table->id('id_approval');
            $table->string('approvable_type', 100);
            $table->unsignedBigInteger('approvable_id');
            $table->enum('role', ['baak']);
            $table->integer('user_id')->unsigned()->nullable();
            $table->enum('status', ['approved', 'rejected']);
            $table->text('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index(['approvable_type', 'approvable_id'], 'idx_approvals_approvable');
            $table->index('role', 'idx_approvals_role');
            $table->index('user_id', 'idx_approvals_user');
            $table->foreign('user_id', 'fk_approvals_user')
                ->references('id_user')->on('users')
                ->onDelete('set null')->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
