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
        Schema::table('absensi_kegiatans', function (Blueprint $table) {
            $table->foreignId('parent_id')->nullable()->constrained('admins')->onDelete('set null');
            $table->foreignId('parent_id_cabang')->nullable()->constrained('admins')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('absensi_kegiatans', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropForeign(['parent_id_cabang']);
            $table->dropColumn(['parent_id', 'parent_id_cabang']);
        });
    }
};
