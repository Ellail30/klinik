<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userdata = [
            [
                'username'=>'Ellail',
                'role'=>'apoteker',
                'password'=>bcrypt('301201')
            ],
            [
                'username'=>'Airin',
                'role'=>'dokter',
                'password'=>bcrypt('12345')
            ],
            [
                'username'=>'Rosefani',
                'role'=>'pimpinan',
                'password'=>bcrypt('891011')
            ],
            ];
            foreach($userdata as $key => $val){
                User::create($val);
            }
    }
}
