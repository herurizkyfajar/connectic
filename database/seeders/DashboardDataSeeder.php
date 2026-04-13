<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use App\Models\RiwayatKegiatan;
use App\Models\AbsensiKegiatan;
use App\Models\Keuangan;
use App\Models\MeetingNote;
use Carbon\Carbon;

class DashboardDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if data already exists
        if (Anggota::count() > 0) {
            $this->command->info('Dashboard data already exists. Skipping...');
            return;
        }

        $this->command->info('Creating dashboard sample data...');

        // Create sample anggota
        $anggotaData = [
            [
                'nama' => 'Ahmad Santoso',
                'email' => 'ahmad@example.com',
                'telepon' => '081234567890',
                'alamat' => 'Jl. Sudirman No. 1, Jakarta',
                'tanggal_lahir' => '1985-03-15',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'Software Engineer',
                'jabatan' => 'Ketua umum',
                'foto' => null,
                'status' => 'Aktif',
                'keterangan' => null,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Siti Nurhaliza',
                'email' => 'siti@example.com',
                'telepon' => '081234567891',
                'alamat' => 'Jl. Thamrin No. 2, Jakarta',
                'tanggal_lahir' => '1988-07-22',
                'jenis_kelamin' => 'Perempuan',
                'pekerjaan' => 'UI/UX Designer',
                'jabatan' => 'Wakil ketua',
                'foto' => null,
                'status' => 'Aktif',
                'keterangan' => null,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Budi Prasetyo',
                'email' => 'budi@example.com',
                'telepon' => '081234567892',
                'alamat' => 'Jl. Gatot Subroto No. 3, Jakarta',
                'tanggal_lahir' => '1990-11-10',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'System Analyst',
                'jabatan' => 'Sekretaris',
                'foto' => null,
                'status' => 'Aktif',
                'keterangan' => null,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Maya Indah',
                'email' => 'maya@example.com',
                'telepon' => '081234567893',
                'alamat' => 'Jl. Rasuna Said No. 4, Jakarta',
                'tanggal_lahir' => '1992-05-18',
                'jenis_kelamin' => 'Perempuan',
                'pekerjaan' => 'Project Manager',
                'jabatan' => 'Bendahara',
                'foto' => null,
                'status' => 'Aktif',
                'keterangan' => null,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Rizki Ramadhan',
                'email' => 'rizki@example.com',
                'telepon' => '081234567894',
                'alamat' => 'Jl. Kuningan No. 5, Jakarta',
                'tanggal_lahir' => '1991-09-25',
                'jenis_kelamin' => 'Laki-laki',
                'pekerjaan' => 'DevOps Engineer',
                'jabatan' => 'Bidang program dan aptika',
                'foto' => null,
                'status' => 'Aktif',
                'keterangan' => null,
                'password' => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($anggotaData as $data) {
            Anggota::create($data);
        }

        $this->command->info('Created ' . count($anggotaData) . ' anggota records.');

        // Create sample kegiatan
        $kegiatanData = [
            [
                'judul' => 'Workshop Laravel Development',
                'deskripsi' => 'Workshop intensif tentang pengembangan web dengan Laravel framework',
                'tanggal_kegiatan' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '17:00',
                'lokasi' => 'Gedung Serbaguna RTIK',
                'penanggung_jawab' => 'Ahmad Santoso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Seminar Teknologi AI',
                'deskripsi' => 'Seminar tentang perkembangan terkini dalam kecerdasan buatan',
                'tanggal_kegiatan' => Carbon::now()->subDays(1)->format('Y-m-d'),
                'waktu_mulai' => '10:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Auditorium Universitas',
                'penanggung_jawab' => 'Siti Nurhaliza',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Meeting Bulanan RTIK',
                'deskripsi' => 'Rapat bulanan untuk evaluasi kegiatan dan perencanaan',
                'tanggal_kegiatan' => Carbon::now()->format('Y-m-d'),
                'waktu_mulai' => '14:00',
                'waktu_selesai' => '16:00',
                'lokasi' => 'Ruang Meeting RTIK',
                'penanggung_jawab' => 'Budi Prasetyo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($kegiatanData as $data) {
            RiwayatKegiatan::create($data);
        }

        $this->command->info('Created ' . count($kegiatanData) . ' kegiatan records.');

        // Get created anggota and kegiatan for absensi
        $anggotas = Anggota::all();
        $kegiatans = RiwayatKegiatan::all();

        // Create absensi data for ranking and notifications
        $absensiData = [];

        // Create absensi with various statuses for ranking
        foreach ($kegiatans as $kegiatan) {
            foreach ($anggotas as $anggota) {
                $status = ['Hadir', 'Tidak Hadir', 'Izin', 'Sakit'][array_rand(['Hadir', 'Tidak Hadir', 'Izin', 'Sakit'])];
                $daysOffset = rand(0, 3);

                $absensiData[] = [
                    'anggota_id' => $anggota->id,
                    'riwayat_kegiatan_id' => $kegiatan->id,
                    'waktu_absen' => Carbon::now()->subDays($daysOffset)->setTime(rand(8, 17), rand(0, 59))->format('Y-m-d H:i:s'),
                    'status_kehadiran' => $status,
                    'ikut_serta_sebagai' => 'Anggota',
                    'ikut_serta_lainnya' => null,
                    'keterangan' => $status == 'Izin' ? 'Izin keluarga' : ($status == 'Sakit' ? 'Demam' : null),
                    'bukti_kehadiran' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // Add recent absensi (last 24 hours) for notifications
        foreach ($anggotas->take(3) as $anggota) {
            $kegiatan = $kegiatans->where('tanggal_kegiatan', '>=', Carbon::now()->subDay())->first();
            if ($kegiatan) {
                $absensiData[] = [
                    'anggota_id' => $anggota->id,
                    'riwayat_kegiatan_id' => $kegiatan->id,
                    'waktu_absen' => Carbon::now()->subHours(rand(1, 23))->format('Y-m-d H:i:s'),
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

        // Add pending absensi (Izin/Sakit in last 3 days) for notifications
        foreach ($anggotas->take(2) as $anggota) {
            $kegiatan = $kegiatans->random();
            $pendingStatus = ['Izin', 'Sakit'][array_rand(['Izin', 'Sakit'])];

            $absensiData[] = [
                'anggota_id' => $anggota->id,
                'riwayat_kegiatan_id' => $kegiatan->id,
                'waktu_absen' => Carbon::now()->subDays(rand(1, 3))->format('Y-m-d H:i:s'),
                'status_kehadiran' => $pendingStatus,
                'ikut_serta_sebagai' => 'Anggota',
                'ikut_serta_lainnya' => null,
                'keterangan' => $pendingStatus == 'Izin' ? 'Izin urusan penting' : 'Flu',
                'bukti_kehadiran' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        foreach (array_chunk($absensiData, 50) as $chunk) {
            AbsensiKegiatan::insert($chunk);
        }

        $this->command->info('Created ' . count($absensiData) . ' absensi records.');

        // Create meeting notes for meeting ranking
        $meetingData = [
            [
                'judul' => 'Rapat Koordinasi Bulan Januari',
                'isi' => 'Rapat koordinasi untuk perencanaan kegiatan bulan Januari 2025',
                'tanggal' => Carbon::now()->subDays(10)->format('Y-m-d'),
                'waktu' => '10:00',
                'tempat' => 'Ruang Meeting RTIK',
                'attendance' => 'Ahmad Santoso, Siti Nurhaliza, Budi Prasetyo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Evaluasi Kegiatan Workshop',
                'isi' => 'Evaluasi hasil workshop Laravel dan perencanaan kegiatan selanjutnya',
                'tanggal' => Carbon::now()->subDays(5)->format('Y-m-d'),
                'waktu' => '15:00',
                'tempat' => 'Ruang Meeting RTIK',
                'attendance' => 'Siti Nurhaliza, Maya Indah, Rizki Ramadhan, Ahmad Santoso',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'judul' => 'Perencanaan Seminar AI',
                'isi' => 'Perencanaan detail untuk seminar teknologi AI yang akan datang',
                'tanggal' => Carbon::now()->subDays(2)->format('Y-m-d'),
                'waktu' => '14:00',
                'tempat' => 'Ruang Meeting RTIK',
                'attendance' => 'Budi Prasetyo, Maya Indah, Rizki Ramadhan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($meetingData as $data) {
            MeetingNote::create($data);
        }

        $this->command->info('Created ' . count($meetingData) . ' meeting notes.');

        $this->command->info('Dashboard sample data created successfully!');
    }
}
