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
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE program_studi MODIFY COLUMN jenjang ENUM('D3', 'S1', 'S2', 'S3') NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE program_studi MODIFY COLUMN jenjang ENUM('D3', 'S1', 'S2', 'S3') NOT NULL");
    }
};
