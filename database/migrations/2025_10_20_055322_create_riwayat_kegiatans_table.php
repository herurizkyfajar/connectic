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
        Schema::create('riwayat_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->text('deskripsi');
            $table->date('tanggal_kegiatan');
            $table->time('waktu_mulai');
            $table->time('waktu_selesai');
            $table->string('lokasi');
            $table->enum('jenis_kegiatan', [
                'Rapat',
                'Pelatihan',
                'Seminar',
                'Workshop',
                'Sosialisasi',
                'Pertemuan',
                'Kegiatan Lainnya'
            ]);
            $table->enum('status', ['Terlaksana', 'Dibatalkan', 'Ditunda'])->default('Terlaksana');
            $table->string('penyelenggara');
            $table->text('catatan')->nullable();
            $table->string('dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_kegiatans');
    }
};
