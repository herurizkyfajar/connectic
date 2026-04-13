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
        Schema::create('pengajuans', function (Blueprint $table) {
            $table->id();
            $table->string('judul_pengajuan');
            $table->date('tanggal_pengajuan');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->unsignedBigInteger('parent_id_cabang')->nullable();
            $table->string('status')->default('Pending');
            $table->text('deskripsi')->nullable();
            $table->timestamps();

            // Optional: Add foreign key constraints if desired, but user didn't explicitly ask for them.
            // Keeping it simple to avoid potential issues if parent tables are not exactly as expected.
            // But indexing is good practice.
            $table->index('parent_id');
            $table->index('parent_id_cabang');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuans');
    }
};
