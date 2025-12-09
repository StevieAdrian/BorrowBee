@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>Add New Book</h2>

    <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title') }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                @foreach($categories as $c)
                    <div class="form-check">
                        <input class="form-check-input"
                            type="checkbox"
                            name="category_ids[]"
                            value="{{ $c->id }}"
                            id="cat{{ $c->id }}"
                            {{ in_array($c->id, old('category_ids', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat{{ $c->id }}">
                            {{ $c->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('category_ids') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Author</label>
            <div class="border rounded p-2" style="max-height: 150px; overflow-y: auto;">
                @foreach($authors as $a)
                    <div class="form-check">
                        <input class="form-check-input"
                            type="checkbox"
                            name="author_ids[]"
                            value="{{ $a->id }}"
                            id="author{{ $a->id }}"
                            {{ in_array($a->id, old('author_ids', [])) ? 'checked' : '' }}>
                        <label class="form-check-label" for="author{{ $a->id }}">
                            {{ $a->name }}
                        </label>
                    </div>
                @endforeach
            </div>
            @error('author_ids') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Price (Rp)</label>
            <input type="number" name="price" class="form-control" value="{{ old('price', 0) }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control">
            @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">PDF File</label>
            <input type="file" name="pdf_file" class="form-control">
            @error('pdf_file') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <button class="btn btn-primary mt-2">Save</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
