<?php

namespace Database\Seeders;

use App\Models\BorrowedBook;
use App\Models\User;
use App\Models\Book;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BorrowedBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role_id', '!=', 1)->pluck('id');
        $books = Book::pluck('id');

        for ($i = 0; $i < 25; $i++) {
            BorrowedBook::create([
                'user_id' => $users->random(),
                'book_id' => $books->random(),
                'borrowed_at' => Carbon::now()->subDays(rand(0, 6))->subHours(rand(0, 23)),
                'due_date' => Carbon::now()->addDays(rand(3, 14)),
                'returned_at' => null
            ]);
        }

        for ($i = 0; $i < 3; $i++) {
            BorrowedBook::create([
                'user_id' => $users->random(),
                'book_id' => $books->random(),
                'borrowed_at' => Carbon::now()->subDays(rand(15, 30)),
                'due_date' => Carbon::now()->subDays(rand(1, 5)),
                'returned_at' => null
            ]);
        }
    }
}
