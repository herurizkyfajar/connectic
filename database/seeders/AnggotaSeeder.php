<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;

class AnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama jika ada
        Anggota::truncate();
        
        // Buat data anggota dummy
        Anggota::create([
            'nama' => 'John Doe',
            'email' => 'john@example.com',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Contoh No. 123, Jakarta',
            'tanggal_lahir' => '1990-01-15',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'Software Developer',
            'jabatan' => 'Ketua umum',
            'foto' => null, // Tidak ada foto untuk testing
            'status' => 'Aktif',
            'keterangan' => 'Anggota aktif dengan pekerjaan di bidang IT'
        ]);
        
        Anggota::create([
            'nama' => 'Jane Smith',
            'email' => 'jane@example.com',
            'telepon' => '081234567891',
            'alamat' => 'Jl. Contoh No. 456, Bandung',
            'tanggal_lahir' => '1992-05-20',
            'jenis_kelamin' => 'Perempuan',
            'pekerjaan' => 'Designer',
            'jabatan' => 'Sekretaris',
            'foto' => null, // Tidak ada foto untuk testing
            'status' => 'Aktif',
            'keterangan' => 'Anggota aktif dengan pekerjaan di bidang desain'
        ]);
        
        Anggota::create([
            'nama' => 'Bob Wilson',
            'email' => 'bob@example.com',
            'telepon' => '081234567892',
            'alamat' => 'Jl. Contoh No. 789, Surabaya',
            'tanggal_lahir' => '1988-12-10',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'Manager',
            'jabatan' => 'Bidang kemitraan dan legal',
            'foto' => null, // Tidak ada foto untuk testing
            'status' => 'Tidak Aktif',
            'keterangan' => 'Anggota tidak aktif'
        ]);
    }
}