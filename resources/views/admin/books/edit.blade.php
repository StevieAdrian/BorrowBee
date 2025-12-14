@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>{{ __('books.edit') }}</h2>

    <form action="{{ route('books.update', $book->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">{{ __('books.title') }}</label>
            <input type="text" name="title" class="form-control" value="{{ $book->title }}">
            @error('title') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('books.category') }}</label>
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
            <label class="form-label">{{ __('books.author') }}</label>
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
            <label class="form-label">{{ __('books.price') }} (Rp)</label>
            <input type="number" step="0.01" name="price" class="form-control" value="{{ $book->price }}">
            @error('price') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('books.cover_current') }}</label><br>
            @if($book->cover_image)
                <img src="{{ asset('storage/' . $book->cover_image) }}" width="100" class="rounded mb-2">
            @else
                <p class="text-muted">{{ __('books.no_image') }}</p>
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('books.new_cover') }} </label>
            <input type="file" name="cover_image" class="form-control">
            @error('cover_image') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('books.new_pdf_file') }}</label>
            <input type="file" name="pdf_file" class="form-control">
            @error('pdf_file') <small class="text-danger">{{ $message }}</small>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">{{ __('books.new_availability') }} </label>
            <select name="is_available" class="form-select">
                <option value="1" {{ $book->is_available ? 'selected' : '' }}>{{ __('books.available') }}</option>
                <option value="0" {{ !$book->is_available ? 'selected' : '' }}>{{ __('books.not_available') }}</option>
            </select>
        </div>

        <button class="btn btn-primary mt-2">{{ __('books.update') }}</button>
        <a href="{{ route('books.index') }}" class="btn btn-secondary mt-2">{{ __('books.back') }}</a>
    </form>
</div>
@endsection
