@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/bookDetail.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="cover-container">
                <img src="{{ asset('assets/books/' . $book->cover_image) }}" class="img-fluid shadow-sm rounded mb-3" alt="{{ $book->title }}">
            </div>

            <div class="d-grid gap-2">
                @if(!$alreadyBought && !$alreadyBorrowed)
                    <form action="{{ route('borrow.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="big-action-btn big-borrow">Borrow</button>
                    </form>

                    <form action="{{ route('transactions.create') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="big-action-btn big-buy">Buy</button>
                    </form>
                @elseif($alreadyBorrowed)
                    <form action="{{ route('return.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="big-action-btn big-return">Return</button>
                    </form>

                @elseif($alreadyBought && !$alreadyReviewed)
                    <a href="{{ route('review.create', $book->id) }}" class="btn btn-info w-100">Make a Review</a>
                @endif
            </div>
        </div>

        <div class="col-md-8">
            <h1 class="fw-bold">{{ $book->title }}</h1>

            <div class="d-flex align-items-center mb-2">
                <span class="star-average me-2" style="--rating: {{ $book->reviews_avg_rating ?? 0 }};">
                    ★★★★★
                </span>
                <span class="fs-5 fw-semibold">{{ number_format($book->reviews_avg_rating ?? 0, 2) }}</span>
                <small class="text-muted ms-2">({{ $book->reviews_count }} ratings)</small>
            </div>


            <p class="mb-3"><strong>Genres:</strong>
                @foreach ($book->categories as $category)
                    <span class="badge bg-light text-dark border">{{ $category->name }}</span>
                @endforeach
            </p>

            <h4 class="fw-bold text-success mb-3">
                Rp {{ number_format($book->price, 0, ',', '.') }}
            </h4>

            <div class="mb-3 position-relative" id="desc-container">
                <strong>Synopsis:</strong><br>

                @php
                    $full = $book->description;
                @endphp

                <div id="desc-short" class="fade-bottom">
                    {!! nl2br(e($full)) !!}
                </div>

                <div id="desc-full" class="d-none">
                    {!! nl2br(e($full)) !!}
                </div>

                @if(strlen($full) > 300)
                    <a href="javascript:void(0)" id="toggle-desc" class="toggle-link d-inline-flex align-items-center mt-1">
                        <span class="label-text">Show more</span>
                        <span class="ms-1 arrow">&#9662;</span> 
                    </a>

                @endif
            </div>

            <div class="d-flex gap-2 my-4 flex-wrap">
                <a href="{{ route('home') }}" class="btn btn-secondary">Back</a>
                <a href="{{ route('review.show', $book->id) }}" class="btn btn-warning">See Reviews</a>
            </div>

            <hr>
            <p class="text-muted">
                <strong>Pages:</strong> {{ $book->pages ?? 320 }}<br>
                <strong>Published:</strong> {{ $book->published_at ?? 'Unknown' }}
            </p>

            <hr class="my-4">

            <div class="author-section">
                <div class="author-header">About the Author</div>

                @foreach ($book->authors as $author)
                    <div class="author-box mb-3">
                        <div class="author-photo">
                            <img src="{{ asset('assets/default-avatar.png') }}" alt="Author placeholder">
                        </div>

                        <div class="author-info">
                            <div class="name">{{ $author->name }}</div>
                            <div class="stats">
                                {{ $author->books_count ?? 0 }} books · 
                                {{ $author->followers_count ?? 0 }} followers
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="my-4">
        </div>
    </div>
</div>

<script>
    document.getElementById('toggle-desc')?.addEventListener('click', function() {
        const shortDesc = document.getElementById('desc-short');
        const fullDesc = document.getElementById('desc-full');

        if (fullDesc.classList.contains('d-none')) {
            shortDesc.classList.add('d-none');
            fullDesc.classList.remove('d-none');
            shortDesc.classList.remove('fade-bottom'); 
            this.textContent = "Show less";
        } else {
            fullDesc.classList.add('d-none');
            shortDesc.classList.remove('d-none');
            shortDesc.classList.add('fade-bottom');
            this.textContent = "Show more";
        }
    });

</script>
@endsection
