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
        $password = 'user123';

        User::insert([
            ['name' => 'stevie', 'email' => 'stevie@example.com', 'password' => bcrypt('Stevie123'), 'role_id' => 1],
        ]);

        User::create([
            'name' => 'Tono',
            'email' => 'tono@gmail.com',
            'password' => bcrypt($password),
            'role_id' => 2,
        ]);
    }
}
