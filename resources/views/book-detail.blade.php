@extends('master.master')
@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/bookDetail.css') }}">
@endsection


@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('assets/books/' . $book->cover_image) }}" class="img-fluid" alt="{{ $book->title }}">
        </div>
        <div class="col-md-8">
            <h2>{{ $book->title }}</h2>
            <p><strong>Price:</strong> Rp {{ number_format($book->price, 0, ',', '.') }}</p>
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
            {{-- lupa nambahin kolom sinopsis jir --}}
            <p><strong>Synopsis:</strong> {{ $book->synopsis }}</p>
            <div class="d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('review.show', $book->id) }}" class="btn btn-warning">See Review</a>
                
                @if($alreadyBought)
                    <a href="{{ route('book.access_pdf', $book) }}" class="btn btn-success">
                        <iconify-icon icon="mdi:book-open-variant"></iconify-icon>
                        Read / Download PDF
                    </a>

                    @if(!$alreadyReviewed)
                        <a href="{{ route('review.create', $book->id) }}" class="btn btn-success">
                            Make a Review
                        </a>
                    @endif
                @elseif($alreadyBorrowed)
                    <a href="{{ route('book.access_pdf', $book) }}" target="_blank" class="btn btn-primary">
                        Read Book Now
                    </a>

                    <form action="{{ route('return.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-danger">Return</button>
                    </form>
                @else
                    <form action="{{ route('borrow.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-primary">Borrow</button>
                    </form>

                    <form action="{{ route('transactions.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="btn btn-primary">Buy</button>
                    </form>
                @endif

                @auth
                    @if(Auth::user()->role_id === 1)
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-warning">
                            Edit Book
                        </a>
                    @endif
                @endauth
            </div> 
        </div>
    </div>
</div>
@endsection
