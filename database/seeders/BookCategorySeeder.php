<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();
        $categories = Category::all();


        foreach ($books as $book) {
            $randomCategories = $categories->random(rand(1, 3))->modelKeys();
            $book->categories()->attach($randomCategories);
        }
    }
}
