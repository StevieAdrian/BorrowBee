@extends('master.master')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4">
            <img src="{{ asset('storage/' . $book->cover_image) }}" class="img-fluid" alt="{{ $book->title }}">
        </div>
        <div class="col-md-8">
            <h2>{{ $book->title }}</h2>
            <p><strong>Price:</strong> Rp {{ number_format($book->price, 0, ',', '.') }}</p>
            <p><strong>Author:</strong> {{ $book->author->name }}</p>
            <p><strong>Category:</strong> {{ $book->category->name }}</p>
            <p><strong>Rating:</strong>
                @for ($i = 1; $i <= 5; $i++)
                    <span class="star-rating {{ $book->rating >= $i ? 'filled' : '' }}">&#9733;</span>
                @endfor
            </p>
            {{-- lupa nambahin kolom sinopsis jir --}}
            <p><strong>Synopsis:</strong> {{ $book->synopsis }}</p>
            <div class="d-flex justify-content-between">
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                <a href="#" class="btn btn-warning">See Review</a>
                <a href="#" class="btn btn-primary">Buy</a>
            </div>
        </div>
    </div>
</div>
@endsection
