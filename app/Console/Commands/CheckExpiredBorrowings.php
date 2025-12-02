<?php

namespace App\Console\Commands;

use App\Models\Book;
use App\Models\BorrowedBook;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CheckExpiredBorrowings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:check-expired-borrowings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
       $expiredBorrowings = BorrowedBook::where('due_date', '<', Carbon::now())
                                     ->whereNull('returned_at')
                                     ->get();

        $count = 0;

        foreach ($expiredBorrowings as $borrowing) {

            $book = Book::find($borrowing->book_id);
            if ($book && !$book->is_available) {
                $book->is_available = true;
                $book->save();
            }

            $user = $borrowing->user;
            if ($user) {
                $user->quota += 1;      
                $user->save();
            }

            $borrowing->returned_at = Carbon::now();
            $borrowing->save();

            $count++;
        }

        $this->info("Reset {$count} expired borrowings successfully.");
        return Command::SUCCESS;
    }
}
