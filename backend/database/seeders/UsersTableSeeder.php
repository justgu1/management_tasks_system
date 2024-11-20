<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin 1',
                'email' => 'admin1@gmail.com',
                'password' => Hash::make('password123'),
                'isAdmin' => true,
            ],
            [
                'name' => 'Admin 2',
                'email' => 'admin2@gmail.com',
                'password' => Hash::make('password123'),
                'isAdmin' => true,
            ],
            [
                'name' => 'Usuario 1',
                'email' => 'usuario1@gmail.com',
                'password' => Hash::make('password123'),
                'isAdmin' => false,
            ],
            [
                'name' => 'Usuario 2',
                'email' => 'usuario2@gmail.com',
                'password' => Hash::make('password123'),
                'isAdmin' => false,
            ],
            [
                'name' => 'Usuario 3',
                'email' => 'usuario3@gmail.com',
                'password' => Hash::make('password123'),
                'isAdmin' => false,
            ],
        ];
        
        DB::table('users')->insert($users);
    }
}
