@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/book.css') }}">
@endsection

@section('content')
<div class="container mt-4">
    <h2>{{ __('books.add_new') }}</h2>

    <div class="add-book-card mt-3">
        <form action="{{ route('books.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('books.category') }}</label>
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
                        <label class="form-label fw-bold">{{ __('books.title') }}</label>
                        <input type="text" name="title" class="form-control"
                               placeholder="{{ __('books.title') }}" value="{{ old('title') }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('books.author') }}</label>
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
                        <label class="form-label fw-bold">{{ __('books.price') }}</label>
                        <input type="number" name="price" class="form-control"
                               placeholder="{{ __('books.price') }}" value="{{ old('price') }}" min="0">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('books.synopsis') }}</label>
                        <textarea name="description" class="form-control textarea-large" placeholder="{{ __('books.synopsis') }}">{{ old('description') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">PDF File</label>
                        <input type="file" name="pdf_file" class="form-control">
                    </div>

                    <div class="d-flex gap-2 mt-3">
                        <button class="btn btn-save px-4">{{ __('books.save') }}</button>
                        <a href="{{ route('books.index') }}" class="btn btn-discard px-4">{{ __('books.discard') }}</a>
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="img-preview-box mb-3" id="imgPreviewBox">
                        <img id="coverPreview" class="default-plus" src="{{ asset('assets/plus-icon.png') }}" alt="Preview">
                    </div>

                        <p class="upload-warning">{{ __('books.upload_warning') }}</p>

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
