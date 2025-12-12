<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ReviewController extends Controller
{
    use AuthorizesRequests;

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

    public function edit(Review $review)
    {
        $this->authorize('update', $review);
        return view('review.edit', compact('review'));
    }

    public function update(Request $request, Review $review)
    {
        $this->authorize('update', $review);

        $request->validate([
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review->update([
            'content' => $request->content,
            'rating' => $request->rating,
        ]);

        return back()->with('success', 'Review updated.');
    }

    public function destroy(Review $review)
    {
        $this->authorize('delete', $review);

        $review->delete();

        return back()->with('success', 'Review deleted.');
    }

    public function toggleLike($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $user = auth()->user();

        $existingLike = $review->likes()->where('user_id', $user->id)->first();

        if ($existingLike) {
            $existingLike->delete();
            return back()->with('success', 'Unliked');
        }

        $review->likes()->create([
            'user_id' => $user->id
        ]);

        return back()->with('success', 'Liked');
    }

    public function toggleDislike($reviewId)
    {
        $review = Review::findOrFail($reviewId);
        $user = auth()->user();

        $review->likes()->where('user_id', $user->id)->delete();

        $existing = $review->dislikes()->where('user_id', $user->id)->first();

        if ($existing) {
            $existing->delete();
            return back()->with('success', 'Dislike removed');
        }

        $review->dislikes()->create([
            'user_id' => $user->id
        ]);

        return back()->with('success', 'Disliked');
    }

}
