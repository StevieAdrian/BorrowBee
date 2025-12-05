@extends('master.master')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/bookDetail.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $book->cover_image) }}" class="img-fluid" alt="{{ $book->title }}">
        </div>
        <div class="col-md-8">
            <h2>{{ $book->title }}</h2>
            <p><strong>Author:</strong> 
                @foreach ($book->authors as $author)
                    {{ $author->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </p>
            <p><strong>Category:</strong>
                @foreach ($book->categories as $category)
                    {{ $category->name }}{{ !$loop->last ? ', ' : '' }}
                @endforeach
            </p>

            <p>
                <strong>Rating:</strong>
                <span class="star-average" style="--rating: {{ $book->reviews_avg_rating }};">&#9733;&#9733;&#9733;&#9733;&#9733;</span>        
            </p>

            <p>
                <strong>Synopsis:</strong> {{ $book->synopsis }}
            </p>

            @if($alreadyBought && !$alreadyReviewed)
                <h4 class="mt-4">Add Your Review</h4>
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
                    <div class="mb-2">
                        <label for="content" class="form-label">Comment:</label>
                        <textarea name="content" id="content" rows="3" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Submit Review</button>
                </form>
            @endif

            <h4 class="mt-4">Reviews</h4>
            @forelse($book->reviews as $review)
                <div class="border p-2 mb-2">
                    <strong>{{ $review->user->name }}</strong> 
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }}">&#9733;</span>
                    @endfor
                    <p>{{ $review->content }}</p>
                </div>
            @empty
                <p>No reviews yet.</p>
            @endforelse

        </div>
    </div>
</div>

@section('custom-js')
    <script src="{{ asset('js/stars.js') }}"></script>
@endsection
@endsection
