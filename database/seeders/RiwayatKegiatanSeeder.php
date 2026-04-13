<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RiwayatKegiatan;

class RiwayatKegiatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kegiatans = [
            [
                'judul' => 'Rapat Koordinasi Bulanan',
                'deskripsi' => 'Rapat koordinasi bulanan untuk membahas program kerja dan evaluasi kegiatan yang telah dilaksanakan.',
                'tanggal_kegiatan' => '2024-10-15',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '11:00',
                'lokasi' => 'Ruang Rapat Utama',
                'jenis_kegiatan' => 'Rapat',
                'status' => 'Terlaksana',
                'penyelenggara' => 'Sekretariat ConnecTIK',
                'catatan' => 'Rapat berjalan lancar dengan kehadiran 15 orang.',
            ],
            [
                'judul' => 'Pelatihan Digital Marketing',
                'deskripsi' => 'Pelatihan intensif tentang strategi digital marketing untuk meningkatkan visibilitas organisasi.',
                'tanggal_kegiatan' => '2024-10-20',
                'waktu_mulai' => '08:00',
                'waktu_selesai' => '17:00',
                'lokasi' => 'Lab Komputer',
                'jenis_kegiatan' => 'Pelatihan',
                'status' => 'Terlaksana',
                'penyelenggara' => 'Bidang Program dan Aptika',
                'catatan' => 'Pelatihan diikuti oleh 25 peserta dengan antusiasme tinggi.',
            ],
            [
                'judul' => 'Seminar Teknologi Informasi',
                'deskripsi' => 'Seminar tentang perkembangan teknologi informasi terkini dan dampaknya terhadap masyarakat.',
                'tanggal_kegiatan' => '2024-10-25',
                'waktu_mulai' => '13:00',
                'waktu_selesai' => '16:00',
                'lokasi' => 'Auditorium Universitas',
                'jenis_kegiatan' => 'Seminar',
                'status' => 'Terlaksana',
                'penyelenggara' => 'Bidang Penelitian dan Pengembangan SDM',
                'catatan' => 'Seminar dihadiri oleh 100 peserta dari berbagai instansi.',
            ],
            [
                'judul' => 'Workshop Pengembangan Aplikasi',
                'deskripsi' => 'Workshop hands-on untuk mengembangkan aplikasi web menggunakan framework modern.',
                'tanggal_kegiatan' => '2024-11-01',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Lab Programming',
                'jenis_kegiatan' => 'Workshop',
                'status' => 'Ditunda',
                'penyelenggara' => 'Bidang Program dan Aptika',
                'catatan' => 'Workshop ditunda karena konflik jadwal dengan kegiatan lain.',
            ],
            [
                'judul' => 'Sosialisasi Program Baru',
                'deskripsi' => 'Sosialisasi program kerja baru untuk tahun 2025 kepada seluruh anggota.',
                'tanggal_kegiatan' => '2024-11-05',
                'waktu_mulai' => '14:00',
                'waktu_selesai' => '16:00',
                'lokasi' => 'Aula Utama',
                'jenis_kegiatan' => 'Sosialisasi',
                'status' => 'Terlaksana',
                'penyelenggara' => 'Ketua Umum',
                'catatan' => 'Sosialisasi berjalan dengan baik dan mendapat respons positif.',
            ],
            [
                'judul' => 'Pertemuan Evaluasi Triwulan',
                'deskripsi' => 'Pertemuan evaluasi capaian program kerja triwulan ketiga tahun 2024.',
                'tanggal_kegiatan' => '2024-11-10',
                'waktu_mulai' => '10:00',
                'waktu_selesai' => '12:00',
                'lokasi' => 'Ruang Rapat Sekretariat',
                'jenis_kegiatan' => 'Pertemuan',
                'status' => 'Dibatalkan',
                'penyelenggara' => 'Sekretaris',
                'catatan' => 'Pertemuan dibatalkan karena sebagian besar peserta tidak dapat hadir.',
            ],
            [
                'judul' => 'Pelatihan Manajemen Proyek',
                'deskripsi' => 'Pelatihan tentang metodologi manajemen proyek untuk meningkatkan efisiensi kerja tim.',
                'tanggal_kegiatan' => '2024-11-15',
                'waktu_mulai' => '08:30',
                'waktu_selesai' => '16:30',
                'lokasi' => 'Hotel Convention Center',
                'jenis_kegiatan' => 'Pelatihan',
                'status' => 'Terlaksana',
                'penyelenggara' => 'Bidang Kemitraan dan Legal',
                'catatan' => 'Pelatihan berhasil meningkatkan pemahaman peserta tentang manajemen proyek.',
            ],
            [
                'judul' => 'Workshop Desain Grafis',
                'deskripsi' => 'Workshop praktis tentang teknik desain grafis untuk keperluan promosi dan publikasi.',
                'tanggal_kegiatan' => '2024-11-20',
                'waktu_mulai' => '09:00',
                'waktu_selesai' => '15:00',
                'lokasi' => 'Lab Multimedia',
                'jenis_kegiatan' => 'Workshop',
                'status' => 'Terlaksana',
                'penyelenggara' => 'Bidang Komunikasi Publik',
                'catatan' => 'Workshop menghasilkan beberapa desain poster yang akan digunakan untuk promosi.',
            ],
        ];

        foreach ($kegiatans as $kegiatan) {
            RiwayatKegiatan::create($kegiatan);
        }

        $this->command->info('Riwayat kegiatan berhasil ditambahkan!');
    }
}
