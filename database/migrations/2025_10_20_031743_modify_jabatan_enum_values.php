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
        // Drop and recreate the enum column with new values
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });
        
        Schema::table('anggotas', function (Blueprint $table) {
            $table->enum('jabatan', [
                'Ketua umum',
                'Wakil ketua',
                'Sekretaris',
                'Bendahara',
                'Bidang kesekretariatan',
                'Bidang kemitraan dan legal',
                'Bidang program dan aptika',
                'Bidang penelitian dan pengembangan sumber daya manusia',
                'Bidang komunikasi publik'
            ])->nullable()->after('pekerjaan');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert to original enum values
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });
        
        Schema::table('anggotas', function (Blueprint $table) {
            $table->enum('jabatan', [
                'Ketua Umum',
                'Wakil Ketua',
                'Sekretaris',
                'Bendahara',
                'BIDANG KESEKRETARIATAN',
                'BIDANG KEMITRAAN DAN LEGAL',
                'BIDANG PROGRAM DAN APTIKA',
                'BIDANG PENELITIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA',
                'BIDANG KOMUNIKASI PUBLIK'
            ])->nullable()->after('pekerjaan');
        });
    }
};
