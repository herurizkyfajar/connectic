<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SertifikatAnggota;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;

class SertifikatAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if there are anggotas and riwayat kegiatans
        $anggotas = Anggota::aktif()->get();
        $kegiatans = RiwayatKegiatan::terlaksana()->get();

        if ($anggotas->isEmpty() || $kegiatans->isEmpty()) {
            $this->command->warn('Tidak ada anggota aktif atau kegiatan terlaksana. Seeder dibatalkan.');
            return;
        }

        // Create sample sertifikats
        $sertifikats = [
            [
                'anggota_id' => $anggotas->first()->id,
                'riwayat_kegiatan_id' => $kegiatans->first()->id,
                'nomor_sertifikat' => 'SERT-' . date('Y') . '-001',
                'tanggal_terbit' => now()->subDays(30),
                'penyelenggara' => $kegiatans->first()->penyelenggara ?? 'RTIK CMH',
                'keterangan' => 'Sertifikat diberikan atas partisipasi aktif dalam kegiatan',
            ],
        ];

        // If there are more anggotas and kegiatans, add more samples
        if ($anggotas->count() > 1 && $kegiatans->count() > 1) {
            $sertifikats[] = [
                'anggota_id' => $anggotas->skip(1)->first()->id,
                'riwayat_kegiatan_id' => $kegiatans->skip(1)->first()->id,
                'nomor_sertifikat' => 'SERT-' . date('Y') . '-002',
                'tanggal_terbit' => now()->subDays(20),
                'penyelenggara' => $kegiatans->skip(1)->first()->penyelenggara ?? 'RTIK CMH',
                'keterangan' => 'Sertifikat penghargaan sebagai peserta terbaik',
            ];
        }

        if ($anggotas->count() > 2 && $kegiatans->count() > 2) {
            $sertifikats[] = [
                'anggota_id' => $anggotas->skip(2)->first()->id,
                'riwayat_kegiatan_id' => $kegiatans->skip(2)->first()->id,
                'nomor_sertifikat' => 'SERT-' . date('Y') . '-003',
                'tanggal_terbit' => now()->subDays(10),
                'penyelenggara' => $kegiatans->skip(2)->first()->penyelenggara ?? 'RTIK CMH',
                'keterangan' => null,
            ];
        }

        foreach ($sertifikats as $sertifikat) {
            SertifikatAnggota::create($sertifikat);
        }

        $this->command->info('Berhasil menambahkan ' . count($sertifikats) . ' sertifikat sample.');
    }
}
