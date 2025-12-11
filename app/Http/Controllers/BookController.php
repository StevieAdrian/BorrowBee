<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Category;
use App\Models\Author;
use App\Models\BorrowedBook;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            'pdf_file' => 'required|mimes:pdf|max:20480',
        ]);

        $data = $request->only(['title', 'price', 'description', 'pdf_file']);
        // dd('store book', $data);
        $data['is_available'] = true;

        // dd(config('cloudinary'));

        // if ($request->hasFile('cover_image')) {
        //     $file = $request->file('cover_image');
        //     $path = Storage::disk('cloudinary')->put('book_covers', $file);
        //     $url = Storage::disk('cloudinary')->url($path);

        //     $data['cover_image'] = $url;
        // }

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public'); 
        }

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = $request->file('pdf_file')->store('pdf', 'public');
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

        $selectedCategories = $book->categories->modelKeys();
        $selectedAuthors = $book->authors->modelKeys();

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
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
            'is_available' => 'nullable|boolean',
        ]);

        $book = Book::findOrFail($id);
        $data = $request->only(['title', 'price', 'description', 'pdf_file', 'is_available']);
        if ($request->hasFile('cover_image')) {
            if ($book->cover_image && Storage::disk('public')->exists($book->cover_image)) {
                Storage::disk('public')->delete($book->cover_image);
            }
            
            $data['cover_image'] = $request->file('cover_image')->store('books', 'public');
        }

        if ($request->hasFile('pdf_file')) {
            if ($book->pdf_file && Storage::disk('public')->exists($book->pdf_file)) {
                Storage::disk('public')->delete($book->pdf_file);
            }

            $data['pdf_file'] = $request->file('pdf_file')->store('pdf', 'public');
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

    public function show($id)
    {
        $book = Book::with(['categories', 'authors'])->withAvg('reviews', 'rating')->findOrFail($id);
        $user = Auth::user();

        $alreadyBorrowed = null;
        $alreadyBought = false;
        $alreadyReviewed = false;

        if($user){
            $alreadyBorrowed = BorrowedBook::where('user_id', $user->id)
                                 ->where('book_id', $book->id)
                                 ->whereNull('returned_at')
                                 ->first();

            $alreadyBought = Transaction::where('user_id', $user->id)
                                 ->where('book_id', $book->id)
                                 ->where('status', 'PAID')
                                 ->exists();
           $alreadyReviewed = $book->reviews()
                                 ->where('user_id', $user->id)
                                 ->exists();
        }
        else{
            $alreadyBorrowed = null;
        }
        return view('book-detail', compact('book', 'alreadyBorrowed', 'alreadyBought', 'alreadyReviewed'));
    }

    public function createBuyView(Book $book)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to purchase this book.');
        }

        $user = Auth::user();

        $alreadyBought = Transaction::where('user_id', $user->id)
                                    ->where('book_id', $book->id)
                                    ->where('status', 'PAID')
                                    ->exists();
                                    
        if ($alreadyBought) {
            return redirect()->route('books.show', $book->id)
                             ->with('info', 'You have already purchased this book and own it permanently.');
        }

        return view('buy-book', compact('book'));
    }

    public function accessPdf(Book $book)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $isPaid = Transaction::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->where('status', 'PAID')
            ->exists();

        $isBorrowed = BorrowedBook::where('user_id', $user->id)
            ->where('book_id', $book->id)
            ->whereNull('returned_at')
            ->exists();

        if (!$isPaid && !$isBorrowed) {
            return redirect()->route('books.show', $book->id)
                ->with('error', 'Anda tidak memiliki akses ke buku ini.');
        }

        // Path file PDF
        $filePath = $book->pdf_file;

        if (!$filePath) {
            return redirect()->route('books.show', $book->id)
                ->with('error', 'File PDF tidak ditemukan karena path kosong di database.');
        } 

        if (!Storage::disk('public')->exists($filePath)) {
            $searchedPath = Storage::disk('public')->path($filePath);
            return redirect()->route('books.show', $book->id)
                ->with('error', "File PDF tidak ditemukan. (Mencari di: {$searchedPath})");
        }

        $pdfUrl = asset('storage/' . $filePath);

        return view('books.pdf-viewer', [
            'bookTitle' => $book->title,
            'pdfUrl'    => $pdfUrl,
            'isPaid'    => $isPaid,
            'filePath'  => $filePath,
        ]);
    }


    public function viewOnly(Book $book)
    {
        $user = Auth::user(); 
        
        if (!$user) {
            return redirect()->route('login');
        }

        $isBorrowed = BorrowedBook::where('user_id', $user->id)
                                         ->where('book_id', $book->id)
                                         ->whereNull('returned_at')
                                         ->exists();
        
        $isPaid = Transaction::where('user_id', $user->id)
                                 ->where('book_id', $book->id)
                                 ->where('status', 'PAID')
                                 ->exists();

        if (!$isBorrowed || $isPaid) { 
            return redirect()->route('book.show', $book->id)
                             ->with('error', 'Access denied. This book is either not borrowed or has been purchased.');
        }

        $pdfUrl = asset('storage/' . $book->pdf_file);
        $bookTitle = $book->title;

        return view('books.pdf-viewer', compact('pdfUrl', 'bookTitle'));

    }
}