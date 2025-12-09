<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $content = [ 
            'Great Book For Bahlil Lovers',
            'Interesting books, I really enjoyed reading it!',
            'I found the plot to be a bit slow in the beginning, but it picked up'
        ];

        $userIds = User::pluck('id')->all();
        $bookIds = Book::pluck('id')->all();

        $allCombinations = [];
        foreach ($userIds as $userId) {
            foreach ($bookIds as $bookId) {
                if (!Review::where('user_id', $userId)->where('book_id', $bookId)->exists()) {
                    $allCombinations[] = ['user_id' => $userId, 'book_id' => $bookId];
                }
            }
        }

        shuffle($allCombinations); 
        $combinationsToSeed = array_slice($allCombinations, 0, min(5, count($allCombinations)));
        
        $count = 0;
        foreach ($combinationsToSeed as $combination) {
            $userId = $combination['user_id'];
            $bookId = $combination['book_id'];
            $book = Book::find($bookId);

            if (!$book) continue; 
            Transaction::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'price' => $book->price,
                'invoice_id' => 'INV-' . uniqid(),
                'status' => 'PAID',
            ]);

            Review::create([
                'user_id' => $userId,
                'book_id' => $bookId,
                'content' => $content[array_rand($content)],
                'rating' => rand(4, 5),
            ]);
            $count++;
        }
    }
}
