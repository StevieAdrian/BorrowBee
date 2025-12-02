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
                @if($alreadyBorrowed)
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
                @endif
                <a href="#" class="btn btn-primary">Buy</a>
            </div>
        </div>
    </div>
</div>
@endsection
