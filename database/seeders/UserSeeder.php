<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id' => 'DK0001',
                'username' => 'dokterumum',
                'email' => 'dokter.umum@gmail.com',
                'password' => Hash::make('password'),
                'role' => 'dokter',
                'jabatan' => 'Dokter Poli Umum',
                'Nama' => 'Dr. Umum',
                'FotoProfil' => null,
                'no_telp' => '081234567890',
            ],
            // [
            //     'id' => 'DK0002',
            //     'username' => 'doktergigi',
            //     'email' => 'dokter.gigi@gmail.com',
            //     'password' => Hash::make('password'),
            //     'role' => 'dokter',
            //     'jabatan' => 'Dokter Poli Gigi',
            //     'Nama' => 'Dr. Gigi',
            //     'FotoProfil' => null,
            //     'no_telp' => '081234567891',
            // ],
            // [
            //     'id' => 'DK0003',
            //     'username' => 'dokterkandungan',
            //     'email' => 'dokter.kandungan@gmail.com',
            //     'password' => Hash::make('password'),
            //     'role' => 'dokter',
            //     'jabatan' => 'Dokter Kandungan',
            //     'Nama' => 'Dr. Kandungan',
            //     'FotoProfil' => null,
            //     'no_telp' => '081234567892',
            // ],
            // [
            //     'id' => 'AD0001',
            //     'username' => 'adminpendaftaran',
            //     'email' => 'admin.pendaftaran@gmail.com',
            //     'password' => Hash::make('password'),
            //     'role' => 'admin',
            //     'jabatan' => 'Admin Pendaftaran',
            //     'Nama' => 'Admin Pendaftaran',
            //     'FotoProfil' => null,
            //     'no_telp' => '081234567893',
            // ],
            // [
            //     'id' => 'APT0001',
            //     'username' => 'apoteker',
            //     'email' => 'apoteker@gmail.com',
            //     'password' => Hash::make('password'),
            //     'role' => 'apoteker',
            //     'jabatan' => 'Apoteker',
            //     'Nama' => 'Apoteker Utama',
            //     'FotoProfil' => null,
            //     'no_telp' => '081234567894',
            // ],
            // [
            //     'id' => 'PM0001',
            //     'username' => 'pimpinan',
            //     'email' => 'pimpinan@gmail.com',
            //     'password' => Hash::make('password'),
            //     'role' => 'pimpinan',
            //     'jabatan' => 'Pimpinan',
            //     'Nama' => 'Pimpinan Klinik',
            //     'FotoProfil' => null,
            //     'no_telp' => '081234567895',
            // ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
