<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;

class BookController extends Controller
{
    //
    public function index()
    {
        $books = Book::with(['category', 'author'])->get();
        return view('admin.books.index', compact('books'));
    }

    public function create()
    {
        $categories = Category::all();
        $authors = Author::all();

        return view('admin.books.create', compact('categories', 'authors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'price' => 'nullable|numeric',
            'cover_image' => 'nullable|image',
        ]);

        $data = $request->only(['title', 'category_id', 'author_id', 'price']);
        $data['is_available'] = true;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        Book::create($data);

        return redirect()->route('books.index')->with('success', 'Book created.');
    }

    public function edit($id)
    {
        $book = Book::findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();

        return view('admin.books.edit', compact('book', 'categories', 'authors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'price' => 'nullable|numeric',
            'cover_image' => 'nullable|image',
        ]);

        $book = Book::findOrFail($id);
        $data = $request->only(['title', 'category_id', 'author_id', 'price']);

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($data);

        return redirect()->route('books.index')->with('success', 'Book updated.');
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }

    public function show($id)
    {
        $book = Book::with(['category', 'author'])->findOrFail($id);
        return view('book-detail', compact('book'));
    }
}
