<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wilayahs', function (Blueprint $table) {
            if (!Schema::hasColumn('wilayahs', 'parent_id_cabang')) {
                $table->unsignedBigInteger('parent_id_cabang')->nullable()->after('parent_id');
                $table->foreign('parent_id_cabang')->references('id')->on('admins')->onDelete('set null');
            }
        });
    }

    public function down(): void
    {
        Schema::table('wilayahs', function (Blueprint $table) {
            if (Schema::hasColumn('wilayahs', 'parent_id_cabang')) {
                $table->dropForeign(['parent_id_cabang']);
                $table->dropColumn('parent_id_cabang');
            }
        });
    }
};
