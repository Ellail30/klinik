<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'id' => Str::uuid(),
            'username' => 'ellail',
            'role' => 'apoteker',
            'password' => bcrypt('301201'),
        ]);
    }
}
