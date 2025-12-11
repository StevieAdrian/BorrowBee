<?php

namespace App\Http\Controllers;

use App\Models\Author;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    //
    public function index()
    {
        $authors = Author::all();
        return view('admin.authors.index', compact('authors'));
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Author::create($request->only('name'));

        return redirect()->route('authors.index')->with('success', 'Author created successfully.');
    }

    public function edit($id)
    {
        $author = Author::findOrFail($id);
        return view('admin.authors.edit', compact('author'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $author = Author::findOrFail($id);
        $author->update($request->only('name'));

        return redirect()->route('authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy($id)
    {
        $author = Author::findOrFail($id);
        $author->delete();

        return redirect()->route('authors.index')->with('success', 'Author deleted successfully.');
    }

    public function profile(Author $author)
    {
        $author->loadCount('followers');

        $books = $author->books()->with('categories')->get();

        return view('author', compact('author', 'books'));
    }

    public function toggleFollow(Author $author)
    {
        $user = auth()->user();

        if ($user->isFollowing($author)) {
            $user->followedAuthors()->detach($author->id);
            $user->refresh();

            return back()->with('success', 'Unfollowed author.');
        }

        $user->followedAuthors()->attach($author->id);
        $user->refresh();

        return back()->with('success', 'Followed author.');
    }

}
