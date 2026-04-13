<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("ALTER TABLE riwayat_kegiatans MODIFY COLUMN status ENUM('Terlaksana', 'Dibatalkan', 'Ditunda', 'Akan Datang') NOT NULL DEFAULT 'Terlaksana'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE riwayat_kegiatans MODIFY COLUMN status ENUM('Terlaksana', 'Dibatalkan', 'Ditunda') NOT NULL DEFAULT 'Terlaksana'");
    }
};
