<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => 'APT001',
            'NamaApoteker' => 'Ellail',
            'username' => 'ellail',
            'role' => 'apoteker',
            'password' => Hash::make('301201'),
        ]);
    }
}
