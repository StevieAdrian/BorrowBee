<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Adventure',
            'Classic',
            'Fiction',
            'Non-Fiction',
            'Science',
            'Science Fiction',
            'Fantasy',
            'Biography',
            'Philosophy',
            'History',
            'Children',
            'Mystery',
            'Romance',
            'Horror'
        ];

        foreach ($categories as $categoryName) {
            Category::create([
                'name' => $categoryName
            ]);
        }
    }
}
