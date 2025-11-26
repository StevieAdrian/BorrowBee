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
            <select name="category_id" class="form-select">
                <option value="">Choose category...</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Author</label>
            <select name="author_id" class="form-select">
                <option value="">Choose author...</option>
                @foreach($authors as $a)
                    <option value="{{ $a->id }}" {{ old('author_id') == $a->id ? 'selected' : '' }}>
                        {{ $a->name }}
                    </option>
                @endforeach
            </select>
            @error('author_id') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Price (Rp)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ old('price', 0) }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Cover Image</label>
            <input type="file" name="cover_image" class="form-control">
            @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button class="btn btn-primary mt-2">Save</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary mt-2">Back</a>
    </form>
</div>
@endsection
