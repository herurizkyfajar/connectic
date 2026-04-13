<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Admin::updateOrCreate(
            ['username' => 'heru_rf'],
            [
                'password' => bcrypt('224589herU!'),
                'name' => 'Heru Administrator',
                'email' => 'heru@admin.com',
                'role' => 'admin',
            ]
        );

        // Seed a default 'pembina' admin user
        \App\Models\Admin::firstOrCreate(
            ['username' => 'pembina'],
            [
                'password' => bcrypt('pembina123'),
                'name' => 'Pembina',
                'email' => 'pembina@admin.com',
                'role' => 'pembina',
            ]
        );

        // Seed new admins requested
        $admins = [
            [
                'username' => 'nasional',
                'password' => '123456789',
                'email' => 'nasional@gmail.com',
                'role' => 'admin_nasional',
                'name' => 'Admin Nasional',
            ],
            [
                'username' => 'provinsi_jabar',
                'password' => '123456789',
                'email' => 'provinsi_jabar@gmail.com',
                'role' => 'admin_provinsi',
                'name' => 'Admin Provinsi Jabar',
            ],
            [
                'username' => 'cabang_cimahi',
                'password' => '123456789',
                'email' => 'cabang_cimahi@gmail.com',
                'role' => 'admin_cabang',
                'name' => 'Admin Cabang Cimahi',
            ],
            [
                'username' => 'komisariat_unjani',
                'password' => '123456789',
                'email' => 'komisariat_unjani@gmail.com',
                'role' => 'admin_komisariat',
                'name' => 'Admin Komisariat Unjani',
            ],
        ];

        foreach ($admins as $admin) {
            \App\Models\Admin::updateOrCreate(
                ['username' => $admin['username']],
                [
                    'password' => bcrypt($admin['password']),
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'role' => $admin['role'],
                ]
            );
        }
    }
}
