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
        Schema::create('wilayahs', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('tipe'); // provinsi, cabang, komisariat
            $table->string('kode')->nullable();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('status')->default('Aktif');
            $table->timestamps();

            $table->foreign('parent_id')->references('id')->on('wilayahs')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wilayahs');
    }
};

