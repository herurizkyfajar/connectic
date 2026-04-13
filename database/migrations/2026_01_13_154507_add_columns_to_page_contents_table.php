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
        Schema::table('page_contents', function (Blueprint $table) {
            if (!Schema::hasColumn('page_contents', 'page_key')) {
                $table->string('page_key')->unique();
            }
            if (!Schema::hasColumn('page_contents', 'title')) {
                $table->string('title')->nullable();
            }
            if (!Schema::hasColumn('page_contents', 'content')) {
                $table->json('content')->nullable();
            }
            if (!Schema::hasColumn('page_contents', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('page_contents', function (Blueprint $table) {
            $table->dropColumn(['page_key', 'title', 'content', 'is_active']);
        });
    }
};
