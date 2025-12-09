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
        $categories = Category::all()->keyBy('name');

        $bookCategoryMap = [
            'Is God a Mathematician?' => ['Science', 'Philosophy'],
            'Don Quixote' => ['Adventure', 'Classic'],
        ];

        foreach ($bookCategoryMap as $title => $categoryNames) {
            $book = Book::where('title', $title)->first();
            if ($book) {
                $categoryIds = Category::whereIn('name', $categoryNames)->pluck('id')->toArray();

                $book->categories()->sync($categoryIds);
            }
        }
    }
}
