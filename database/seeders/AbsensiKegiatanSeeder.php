<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AbsensiKegiatan;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;
use Carbon\Carbon;

class AbsensiKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing anggota and kegiatan
        $anggotas = Anggota::all();
        $kegiatans = RiwayatKegiatan::all();

        if ($anggotas->count() == 0 || $kegiatans->count() == 0) {
            $this->command->warn('No anggota or kegiatan found. Please run AnggotaSeeder and RiwayatKegiatanSeeder first.');
            return;
        }

        $absensiData = [];

        // Generate absensi data untuk beberapa hari terakhir
        $today = Carbon::now();
        $daysBack = 30;

        // Status options
        $statuses = ['Hadir', 'Tidak Hadir', 'Izin', 'Sakit'];
        $roles = ['Anggota', 'Panitia', 'Pembicara', 'Moderator', 'Lainnya'];

        // Generate absensi untuk setiap anggota dan kegiatan
        foreach ($kegiatans as $kegiatan) {
            foreach ($anggotas->random(min(5, $anggotas->count())) as $anggota) {
                $randomDays = rand(0, $daysBack);
                $absensiDate = $today->copy()->subDays($randomDays);

                // Skip if absensi date is before kegiatan date
                if ($absensiDate->lt($kegiatan->tanggal_kegiatan)) {
                    continue;
                }

                $status = $statuses[array_rand($statuses)];
                $role = $roles[array_rand($roles)];

                $absensiData[] = [
                    'anggota_id' => $anggota->id,
                    'riwayat_kegiatan_id' => $kegiatan->id,
                    'waktu_absen' => $absensiDate->format('Y-m-d H:i:s'),
                    'status_kehadiran' => $status,
                    'ikut_serta_sebagai' => $role,
                    'ikut_serta_lainnya' => $role == 'Lainnya' ? 'Koordinator' : null,
                    'keterangan' => $status == 'Izin' ? 'Izin keluarga' : ($status == 'Sakit' ? 'Demam' : null),
                    'bukti_kehadiran' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Add some recent absensi (last 24 hours) for notifications
        foreach ($anggotas->random(3) as $anggota) {
            foreach ($kegiatans->where('tanggal_kegiatan', '>=', $today->subDays(1))->take(2) as $kegiatan) {
                $absensiData[] = [
                    'anggota_id' => $anggota->id,
                    'riwayat_kegiatan_id' => $kegiatan->id,
                    'waktu_absen' => $today->copy()->subHours(rand(1, 23))->format('Y-m-d H:i:s'),
                    'status_kehadiran' => 'Hadir',
                    'ikut_serta_sebagai' => 'Anggota',
                    'ikut_serta_lainnya' => null,
                    'keterangan' => null,
                    'bukti_kehadiran' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Add some pending absensi (Izin/Sakit in last 3 days) for notifications
        foreach ($anggotas->random(2) as $anggota) {
            $pendingStatus = ['Izin', 'Sakit'][array_rand(['Izin', 'Sakit'])];
            $kegiatan = $kegiatans->random();

            $absensiData[] = [
                'anggota_id' => $anggota->id,
                'riwayat_kegiatan_id' => $kegiatan->id,
                'waktu_absen' => $today->copy()->subDays(rand(1, 3))->format('Y-m-d H:i:s'),
                'status_kehadiran' => $pendingStatus,
                'ikut_serta_sebagai' => 'Anggota',
                'ikut_serta_lainnya' => null,
                'keterangan' => $pendingStatus == 'Izin' ? 'Izin urusan penting' : 'Flu',
                'bukti_kehadiran' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Add some today absensi for dashboard
        foreach ($anggotas->random(5) as $anggota) {
            $kegiatan = $kegiatans->where('tanggal_kegiatan', $today->format('Y-m-d'))->first();
            if ($kegiatan) {
                $absensiData[] = [
                    'anggota_id' => $anggota->id,
                    'riwayat_kegiatan_id' => $kegiatan->id,
                    'waktu_absen' => $today->copy()->setTime(rand(8, 17), rand(0, 59))->format('Y-m-d H:i:s'),
                    'status_kehadiran' => 'Hadir',
                    'ikut_serta_sebagai' => 'Anggota',
                    'ikut_serta_lainnya' => null,
                    'keterangan' => null,
                    'bukti_kehadiran' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Insert all absensi data
        foreach (array_chunk($absensiData, 100) as $chunk) {
            AbsensiKegiatan::insert($chunk);
        }

        $this->command->info('AbsensiKegiatan seeder completed successfully!');
        $this->command->info('Created ' . count($absensiData) . ' sample absensi records.');
    }
}
