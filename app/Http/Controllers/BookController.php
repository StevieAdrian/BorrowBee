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
        $books = Book::with(['categories', 'authors'])->get();
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
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'author_ids' => 'required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
            'price' => 'nullable|numeric',
            'cover_image' => 'nullable|image',
            'description' => 'nullable|string',
        ]);

        $data = $request->only(['title', 'price', 'description']);
        $data['is_available'] = true;

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book = Book::create($data);
        $book->categories()->attach($request->category_ids);
        $book->authors()->attach($request->author_ids);

        return redirect()->route('books.index')->with('success', 'Book created.');
    }

    public function edit($id)
    {
        $book = Book::with(['categories', 'authors'])->findOrFail($id);
        $categories = Category::all();
        $authors = Author::all();

        $selectedCategories = $book->categories()->modelKeys();
        $selectedAuthors = $book->authors()->modelKeys();

        return view('admin.books.edit', compact('book', 'categories', 'authors', 'selectedCategories', 'selectedAuthors'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category_ids' => 'required|array|min:1',
            'category_ids.*' => 'exists:categories,id',
            'author_ids' => 'required|array|min:1',
            'author_ids.*' => 'exists:authors,id',
            'price' => 'nullable|numeric',
            'cover_image' => 'nullable|image', 
            'description' => 'nullable|string',
        ]);

        $book = Book::findOrFail($id);
        $data = $request->only(['title', 'price', 'description']);
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('covers', 'public');
        }

        $book->update($data);
        $book->categories()->sync($request->category_ids);
        $book->authors()->sync($request->author_ids);

        return redirect()->route('books.index')->with('success', 'Book updated.');
    }

    public function destroy($id)
    {
        Book::findOrFail($id)->delete();
        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}
