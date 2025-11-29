@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>Edit Book</h2>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select">
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ $book->category_id == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Author</label>
            <select name="author_id" class="form-select">
                @foreach($authors as $a)
                    <option value="{{ $a->id }}" {{ $book->author_id == $a->id ? 'selected' : '' }}>
                        {{ $a->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Price (Rp)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $book->price }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Current Cover</label><br>
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" width="100" class="rounded mb-2">
            @else
                <p class="text-muted">No image uploaded</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">New Cover (optional)</label>
            <input type="file" name="cover_image" class="form-control">
            @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary mt-2">Update</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
