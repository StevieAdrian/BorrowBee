@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/bookDetail.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <h2>Review for: {{ $book->title }}</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('review.store', $book->id) }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Rating:</label>
            <div id="star-rating" class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star" data-value="{{ $i }}">&#9733;</span>
                @endfor
            </div>
            <input type="hidden" name="rating" id="rating" required>
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Comment:</label>
            <textarea name="content" id="content" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Submit Review</button>
    </form>
</div>

@section('custom-js')
    <script src="{{ asset('js/stars.js') }}"></script>
@endsection

@endsection
