<?php

namespace App\Http\Controllers;

use App\Models\BorrowedBook;
use App\Models\Review;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BorrowedBookController extends Controller
{
    
    function borrow(Request $request)
    {
        $user = Auth::user();

         $alreadyBorrowed = BorrowedBook::where('user_id', $user->id)
                            ->where('book_id', $request->book_id)
                            ->whereNull('returned_at')
                            ->first();

        if($user->quota <= 0) {
            return redirect()->back()->with('error', 'You have reached your borrowing quota.');
        }
        elseif ($alreadyBorrowed) {
            return redirect()->back()->with('error', 'You have already borrowed this book.');
        }
        else{
            BorrowedBook::create([
                'user_id' => $user->id,
                'book_id' => $request->book_id,
                'borrowed_at' => Carbon::now(),
                'due_date' => Carbon::now()->addMonth(),
                // 'due_date' => Carbon::now()->addSeconds(10),
            ]);

            $idUser = User::findOrFail($user->id);
            $idUser->quota -= 1;
            $idUser->save();
        }

        return redirect('home')->with('success', 'Book borrowed successfully.');
    }

    function returnBook(Request $request)
    {
        $user = Auth::user();

        $borrowedBook = BorrowedBook::where('user_id', $user->id)
                                    ->where('book_id', $request->book_id)
                                    ->whereNull('returned_at')
                                    ->first();

        if ($borrowedBook) {
            $borrowedBook->returned_at = Carbon::now();
            $borrowedBook->save();

            $idUser = User::findOrFail($user->id);
            $idUser->quota += 1;
            $idUser->save();
        }

        return redirect()->back()->with('success', 'Book returned successfully.');
    }

    public function myBooks()
    {
        $user = Auth::user();

        $transactions = Transaction::with('book')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $borrowedBooks = BorrowedBook::with('book')
            ->where('user_id', $user->id)
            ->orderBy('borrowed_at', 'desc')
            ->get();

        $alreadyReviewed = Review::where('user_id', $user->id)
            ->pluck('book_id')         
            ->toArray();     

        return view('books.my-books', compact('transactions', 'borrowedBooks', 'alreadyReviewed'));
    }

}
