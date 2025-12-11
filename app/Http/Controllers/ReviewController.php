<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    function index()
    {
        $books = Book::with(['categories', 'authors'])->withAvg('reviews', 'rating')->get();
        return view('review.list', compact('books'));
    }

    function showReview($id){ 
        $book = Book::with(['categories', 'authors', 'reviews.user'])->withAvg('reviews', 'rating')->findOrFail($id);

        $user = Auth::user();
        $alreadyBought = false;
        $alreadyReviewed = false;

        if($user){
            $alreadyBought = $book->transactions()
                                ->where('user_id', $user->id)
                                ->where('status', 'PAID')
                                ->exists();

            $alreadyReviewed = $book->reviews()
                                ->where('user_id', $user->id)
                                ->exists();
        }

        return view('review.index', compact('book', 'alreadyBought', 'alreadyReviewed'));
    }

    function review(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        return view('review.create', compact('book'));
    }

    function store(Request $request, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $book = Book::findOrFail($id);

        $existingReview = $book->reviews()->where('user_id', Auth::user()->id)->first();
        
        if ($existingReview) {
            return back()->with('error', 'You have already reviewed this book.');
        } 

        $book->reviews()->create([
            'content' => $request->input('content'),
            'rating' => $request->input('rating'),
            'user_id' => Auth::user()->id,
        ]);

        return back()->with('success', 'Review submitted.');
    }


}
