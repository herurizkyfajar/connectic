<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Keuangan;
use Carbon\Carbon;

class KeuanganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Pemasukan
            [
                'jenis' => 'masuk',
                'jumlah' => 500000,
                'kategori' => 'Iuran Anggota',
                'keterangan' => 'Iuran bulanan anggota RTIK periode Januari 2025',
                'tanggal' => Carbon::now()->subDays(30),
                'sumber' => 'Iuran Anggota',
                'penerima' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'masuk',
                'jumlah' => 1000000,
                'kategori' => 'Donasi',
                'keterangan' => 'Donasi dari perusahaan teknologi untuk kegiatan workshop',
                'tanggal' => Carbon::now()->subDays(25),
                'sumber' => 'PT. Teknologi Maju',
                'penerima' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'masuk',
                'jumlah' => 750000,
                'kategori' => 'Sponsor',
                'keterangan' => 'Sponsor dari event seminar teknologi',
                'tanggal' => Carbon::now()->subDays(20),
                'sumber' => 'Event Organizer',
                'penerima' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'masuk',
                'jumlah' => 300000,
                'kategori' => 'Iuran Anggota',
                'keterangan' => 'Iuran bulanan anggota RTIK periode Februari 2025',
                'tanggal' => Carbon::now()->subDays(15),
                'sumber' => 'Iuran Anggota',
                'penerima' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'masuk',
                'jumlah' => 2000000,
                'kategori' => 'Penjualan',
                'keterangan' => 'Penjualan merchandise RTIK (kaos dan mug)',
                'tanggal' => Carbon::now()->subDays(10),
                'sumber' => 'Penjualan Merchandise',
                'penerima' => null,
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Pengeluaran
            [
                'jenis' => 'keluar',
                'jumlah' => 800000,
                'kategori' => 'Operasional',
                'keterangan' => 'Biaya sewa tempat meeting bulanan',
                'tanggal' => Carbon::now()->subDays(28),
                'sumber' => null,
                'penerima' => 'Gedung Serbaguna',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'keluar',
                'jumlah' => 450000,
                'kategori' => 'Konsumsi',
                'keterangan' => 'Konsumsi untuk meeting anggota',
                'tanggal' => Carbon::now()->subDays(28),
                'sumber' => null,
                'penerima' => 'Catering Service',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'keluar',
                'jumlah' => 1200000,
                'kategori' => 'Kegiatan',
                'keterangan' => 'Biaya workshop teknologi dengan narasumber',
                'tanggal' => Carbon::now()->subDays(22),
                'sumber' => null,
                'penerima' => 'Narasumber Workshop',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'keluar',
                'jumlah' => 300000,
                'kategori' => 'Transportasi',
                'keterangan' => 'Biaya transportasi untuk kunjungan ke perusahaan IT',
                'tanggal' => Carbon::now()->subDays(18),
                'sumber' => null,
                'penerima' => 'Travel Agent',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'keluar',
                'jumlah' => 600000,
                'kategori' => 'Peralatan',
                'keterangan' => 'Pembelian peralatan presentasi (projector dan screen)',
                'tanggal' => Carbon::now()->subDays(12),
                'sumber' => null,
                'penerima' => 'Toko Elektronik',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'keluar',
                'jumlah' => 250000,
                'kategori' => 'Operasional',
                'keterangan' => 'Biaya administrasi dan dokumentasi kegiatan',
                'tanggal' => Carbon::now()->subDays(8),
                'sumber' => null,
                'penerima' => 'Admin RTIK',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'jenis' => 'keluar',
                'jumlah' => 50000,
                'kategori' => 'Lainnya',
                'keterangan' => 'Biaya kecil untuk keperluan kantor',
                'tanggal' => Carbon::now()->subDays(5),
                'sumber' => null,
                'penerima' => 'Supplier Office',
                'bukti' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($data as $item) {
            Keuangan::create($item);
        }

        $this->command->info('Keuangan seeder completed successfully!');
        $this->command->info('Created ' . count($data) . ' sample financial records.');
    }
}
