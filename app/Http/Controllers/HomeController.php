<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $query = Book::query();

        if ($request->search) {
            $query->where('title', 'LIKE', '%' . $request->search . '%');
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->sort === 'price_asc') {
            $query->orderBy('price', 'asc');
        }
        if ($request->sort === 'price_desc') {
            $query->orderBy('price', 'desc');
        }

        $books = $query->paginate(12);
        $categories = Category::all();

        return view('home', compact('books', 'categories'));
    }

    public function show($id)
    {
        $book = Book::with(['reviews.user'])->findOrFail($id);

        return view('book-detail', compact('book'));
    }
}
