<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookAuthorMap = [
            'Is God a Mathematician?' => ['Mario Livio'],
            'Don Quixote' => ['Miguel de Cervantes'],
        ];

        foreach ($bookAuthorMap as $title => $authorNames) {
            $book = Book::where('title', $title)->first();
            if ($book) {
                $authorIds = Author::whereIn('name', $authorNames)->pluck('id')->toArray();

                $book->authors()->sync($authorIds);
            }
        }
    }
}
