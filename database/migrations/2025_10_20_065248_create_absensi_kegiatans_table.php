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
        Schema::create('absensi_kegiatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('anggota_id')->constrained('anggotas')->onDelete('cascade');
            $table->foreignId('riwayat_kegiatan_id')->constrained('riwayat_kegiatans')->onDelete('cascade');
            $table->timestamp('waktu_absen')->useCurrent();
            $table->enum('status_kehadiran', ['Hadir', 'Tidak Hadir', 'Izin', 'Sakit'])->default('Hadir');
            $table->text('keterangan')->nullable();
            $table->string('bukti_kehadiran')->nullable(); // Foto atau dokumen
            $table->timestamps();
            
            // Unique constraint untuk mencegah absensi ganda
            $table->unique(['anggota_id', 'riwayat_kegiatan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensi_kegiatans');
    }
};
