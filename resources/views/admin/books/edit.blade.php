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
            <label class="form-label">Categories</label>
            <div class="border rounded p-2">
                @foreach($categories as $c)
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="category_ids[]" 
                            value="{{ $c->id }}" 
                            class="form-check-input"
                            {{ in_array($c->id, $selectedCategories) ? 'checked' : '' }}
                        >
                        <label class="form-check-label">{{ $c->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('category_ids') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
        </div>


        <div class="mb-3">
            <label class="form-label">Authors</label>
            <div class="border rounded p-2">
                @foreach($authors as $a)
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            name="author_ids[]" 
                            value="{{ $a->id }}" 
                            class="form-check-input"
                            {{ in_array($a->id, $selectedAuthors) ? 'checked' : '' }}
                        >
                        <label class="form-check-label">{{ $a->name }}</label>
                    </div>
                @endforeach
            </div>
            @error('author_ids') 
                <small class="text-danger">{{ $message }}</small> 
            @enderror
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

        <div class="mb-3">
            <label class="form-label">PDF File (optional)</label>
            <input type="file" name="pdf_file" class="form-control">
            @error('pdf_file') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Availability (optional)</label>
            <select name="is_available" class="form-select">
                <option value="1" {{ $book->is_available ? 'selected' : '' }}>Available</option>
                <option value="0" {{ !$book->is_available ? 'selected' : '' }}>Not Available</option>
            </select>
        </div>

        <button class="btn btn-primary mt-2">Update</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
