@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <h2>Add New Book</h2>

    <div class="add-book-card mt-3">
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Category</label>
                        <select class="form-select select2" name="category_ids[]" multiple>
                            @foreach($categories as $c)
                                <option value="{{ $c->id }}"
                                    {{ in_array($c->id, old('category_ids', [])) ? 'selected' : '' }}>
                                    {{ $c->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Title</label>
                        <input type="text" name="title" class="form-control"
                               placeholder="Title" value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Author</label>
                        <select class="form-select select2" name="author_ids[]" multiple>
                            @foreach($authors as $a)
                                <option value="{{ $a->id }}"
                                    {{ in_array($a->id, old('author_ids', [])) ? 'selected' : '' }}>
                                    {{ $a->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Price</label>
                        <input type="number" name="price" class="form-control"
                               placeholder="Price" value="{{ old('price') }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Synopsis</label>
                        <textarea name="description" class="form-control textarea-large" placeholder="Synopsis">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">PDF File</label>
                        <input type="file" name="pdf_file" class="form-control">
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-save px-4">Save</button>
                        <a href="{{ route('books.index') }}" class="btn btn-discard px-4">Discard</a>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="img-preview-box mb-3" id="imgPreviewBox">
                        <img id="coverPreview" class="default-plus" src="{{ asset('assets/plus-icon.png') }}" alt="Preview">
                    </div>

                        <p class="upload-warning">* Please upload the book cover image</p>

                    <input type="file" name="cover_image" id="coverInput" class="form-control mb-2" style="display: none;">
                    
                </div>
            </div>

        </form>
    </div>
</div>

@section('custom-js')
    <script src="{{ asset('js/book.js') }}"></script>
@endsection

@endsection
