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
        $avatars = [ 
            'avatar_0.png',
            'avatar_1.jpg',
            'avatar_2.jpeg',
            'avatar_3.jpg',
        ];
         
        $passwordTono = 'tono123';
        $passwordRendy = 'rendy123';
        $passwordStevie = 'stevie23';

        User::insert([
            [
                'name' => 'stevie', 
                'email' => 'stevie@example.com', 
                'password' => bcrypt('Stevie123'), 
                'avatar' => $avatars[array_rand($avatars)],
                'role_id' => 1,
            ],
            [
                'name' => 'Tono',
                'email' => 'tono@gmail.com',
                'password' => bcrypt($passwordTono),
                'avatar' => $avatars[array_rand($avatars)],
                'role_id' => 1,
            ],
            [
                'name' => 'Rendy',
                'email' => 'rendy@gmail.com',
                'password' => bcrypt($passwordRendy),
                'avatar' => $avatars[array_rand($avatars)],
                'role_id' => 1,
            ],
            [
                'name' => 'Stevie',
                'email' => 'adrianstevie0@gmail.com',
                'password' => bcrypt($passwordStevie),
                'avatar' => $avatars[array_rand($avatars)],
                'role_id' => 2,
            ]
        ]);
    }
}
