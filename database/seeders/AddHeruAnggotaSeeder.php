<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class AddHeruAnggotaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create new anggota with specific credentials
        Anggota::create([
            'nama' => 'Heru Anggota',
            'email' => 'heru_anggota@example.com',
            'password' => Hash::make('224589herU!'),
            'telepon' => '081234567893',
            'alamat' => 'Jl. Anggota No. 123, Jakarta',
            'tanggal_lahir' => '1985-03-15',
            'jenis_kelamin' => 'Laki-laki',
            'pekerjaan' => 'Software Engineer',
            'jabatan' => 'Ketua umum',
            'foto' => null,
            'status' => 'Aktif',
            'keterangan' => 'Anggota aktif dengan keahlian di bidang teknologi'
        ]);
        
        echo "Anggota 'Heru Anggota' berhasil ditambahkan!\n";
        echo "Email: heru_anggota@example.com\n";
        echo "Password: 224589herU!\n";
    }
}
