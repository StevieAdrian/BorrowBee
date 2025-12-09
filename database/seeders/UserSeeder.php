<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $passwordTono = 'tono123';
        $passwordRendy = 'rendy123';
        $passwordStevie = 'stevie23';

        User::insert([
            [
                'name' => 'stevie', 
                'email' => 'stevie@example.com', 
                'password' => bcrypt('Stevie123'), 
                'role_id' => 1,
            ],
            [
                'name' => 'Tono',
                'email' => 'tono@gmail.com',
                'password' => bcrypt($passwordTono),
                'role_id' => 2,
            ],
            [
                'name' => 'Rendy',
                'email' => 'rendy@gmail.com',
                'password' => bcrypt($passwordRendy),
                'role_id' => 2,
            ],
            [
                'name' => 'Stevie',
                'email' => 'adrianstevie0@gmail.com',
                'password' => bcrypt($passwordStevie),
                'role_id' => 2,
            ]
        ]);
    }
}
