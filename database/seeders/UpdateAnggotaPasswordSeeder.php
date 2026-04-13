<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Anggota;
use Illuminate\Support\Facades\Hash;

class UpdateAnggotaPasswordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update existing anggota with default password
        $anggotas = Anggota::all();
        
        foreach ($anggotas as $anggota) {
            if (!$anggota->password) {
                $anggota->password = Hash::make('password123');
                $anggota->save();
            }
        }
        
        echo "Updated " . $anggotas->count() . " anggota with default password: password123\n";
    }
}
