<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            BookSeeder::class,
            AuthorSeeder::class,
            CategorySeeder::class,
            BookAuthorSeeder::class,
            BookCategorySeeder::class,
            ReviewSeeder::class,
        ]);
    }
}
