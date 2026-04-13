<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\AbsensiKegiatan;
use App\Models\Anggota;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $absensis = AbsensiKegiatan::with('anggota')->get();
        
        foreach ($absensis as $absensi) {
            if ($absensi->anggota) {
                // Update langsung via query builder untuk menghindari event/observer jika ada
                // dan memastikan update terjadi meskipun timestamp tidak berubah
                AbsensiKegiatan::where('id', $absensi->id)->update([
                    'parent_id' => $absensi->anggota->parent_id,
                    'parent_id_cabang' => $absensi->anggota->parent_id_cabang,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        AbsensiKegiatan::query()->update([
            'parent_id' => null,
            'parent_id_cabang' => null,
        ]);
    }
};
