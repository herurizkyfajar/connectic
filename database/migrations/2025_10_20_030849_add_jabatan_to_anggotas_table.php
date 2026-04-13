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
        Schema::table('anggotas', function (Blueprint $table) {
            $table->dropColumn('jabatan');
        });
    }
};
