<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    public function definition(): array
    {
        $content = [ 
            'Great Book For Bahlil Lovers',
            'Interesting books, I really enjoyed reading it!',
            'I found the plot to be a bit slow in the beginning, but it picked up'
        ];

        $user = User::inRandomOrder()->first();
        $book = Book::inRandomOrder()->first();

        if (Review::where('user_id', $user->id)->where('book_id', $book->id)->exists()) {
            return [];
        }
        Transaction::create([
            'user_id' => $user->id,
            'book_id' => $book->id,
            'price' => $book->price,
            'invoice_id' => 'INV-' . uniqid(),
            'status' => 'PAID',
        ]);

       return [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'content' => $content[array_rand($content)],
            'rating' => $this->faker->numberBetween(1, 5),
        ];
    }
}
