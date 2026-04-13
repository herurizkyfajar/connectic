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
        Schema::table('anggotas', function (Blueprint $table) {
            // Update existing data to title case
            DB::statement("UPDATE anggotas SET jabatan = CASE 
                WHEN jabatan = 'Ketua Umum' THEN 'Ketua umum'
                WHEN jabatan = 'Wakil Ketua' THEN 'Wakil ketua'
                WHEN jabatan = 'Sekretaris' THEN 'Sekretaris'
                WHEN jabatan = 'Bendahara' THEN 'Bendahara'
                WHEN jabatan = 'BIDANG KESEKRETARIATAN' THEN 'Bidang kesekretariatan'
                WHEN jabatan = 'BIDANG KEMITRAAN DAN LEGAL' THEN 'Bidang kemitraan dan legal'
                WHEN jabatan = 'BIDANG PROGRAM DAN APTIKA' THEN 'Bidang program dan aptika'
                WHEN jabatan = 'BIDANG PENELITIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA' THEN 'Bidang penelitian dan pengembangan sumber daya manusia'
                WHEN jabatan = 'BIDANG KOMUNIKASI PUBLIK' THEN 'Bidang komunikasi publik'
                ELSE jabatan
            END");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('anggotas', function (Blueprint $table) {
            // Revert to original format
            DB::statement("UPDATE anggotas SET jabatan = CASE 
                WHEN jabatan = 'Ketua umum' THEN 'Ketua Umum'
                WHEN jabatan = 'Wakil ketua' THEN 'Wakil Ketua'
                WHEN jabatan = 'Sekretaris' THEN 'Sekretaris'
                WHEN jabatan = 'Bendahara' THEN 'Bendahara'
                WHEN jabatan = 'Bidang kesekretariatan' THEN 'BIDANG KESEKRETARIATAN'
                WHEN jabatan = 'Bidang kemitraan dan legal' THEN 'BIDANG KEMITRAAN DAN LEGAL'
                WHEN jabatan = 'Bidang program dan aptika' THEN 'BIDANG PROGRAM DAN APTIKA'
                WHEN jabatan = 'Bidang penelitian dan pengembangan sumber daya manusia' THEN 'BIDANG PENELITIAN DAN PENGEMBANGAN SUMBER DAYA MANUSIA'
                WHEN jabatan = 'Bidang komunikasi publik' THEN 'BIDANG KOMUNIKASI PUBLIK'
                ELSE jabatan
            END");
        });
    }
};
