@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/bookDetail.css') }}">
@endsection

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-4 text-center">
            <div class="cover-container">
                <img src="{{ $book->cover_url}}" class="img-fluid shadow-sm rounded mb-3" alt="{{ $book->title }}">
            </div>

            <div class="d-grid gap-2">
                @if($alreadyBought)
                    <a href="{{ route('book.access_pdf', $book) }}" class="big-action-btn big-borrow">
                        <iconify-icon icon="mdi:book-open-variant"></iconify-icon>
                        Read / Download PDF
                    </a>

                    @if(!$alreadyReviewed)
                       <a href="{{ route('review.create', $book->id) }}" class="btn btn-info w-100">Make a Review</a>
                    @endif
                @elseif($alreadyBorrowed)
                    <a href="{{ route('book.access_pdf', $book) }}" target="_blank" class="big-action-btn big-borrow">
                        Read Book Now
                    </a>

                    <form action="{{ route('return.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="big-action-btn big-return">Return</button>
                    </form>
                    @else
                    <form action="{{ route('borrow.book') }}" method="POST">
                        @csrf
                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                        <button type="submit" class="big-action-btn big-borrow">Borrow</button>
                    </form>
                    
                    <a href="{{ route('transactions.create_view', $book->id) }}" class="big-action-btn big-buy">
                        Buy
                    </a>
                @endif

                @auth
                    @if(Auth::user()->role_id === 2)
                        <a href="{{ route('books.edit', $book->id) }}" class="big-action-btn big-borrow">
                            Edit Book
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        <div class="col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h1 class="fw-bold m-0">{{ $book->title }}</h1>

                <a href="{{ route('home') }}" class="btn btn-secondary">
                    Back
                </a>
            </div>

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

            <hr>
            <p class="text-muted">
                <strong>Pages:</strong> {{ $book->pages ?? 320 }}<br>
                <strong>Published:</strong> {{ $book->published_at ?? 'Unknown' }}
            </p>

            <hr class="my-4">

            <div class="author-section">
                <div class="author-header">About the Author</div>

                @foreach ($book->authors as $author)
                    <div class="author-box mb-3 d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="author-photo me-3">
                                <img src="{{ asset('assets/default-avatar.png') }}" alt="Author placeholder">
                            </div>

                            <div class="author-info">
                                <div class="name fw-bold">{{ $author->name }}</div>
                                <div class="stats text-muted">
                                    {{ $author->books_count ?? 0 }} books · 
                                    {{ $author->followers_count ?? 0 }} followers
                                </div>

                                <a href="{{ route('author.profile', [$author->id, 'from' => $book->id]) }}" class="btn btn-outline-dark btn-sm mt-2 me-2">
                                    View Profile
                                </a>
                            </div>
                        </div>

                        <div class="ms-3">
                            @auth
                                <form action="{{ route('author.follow', $author->id) }}" method="POST">
                                    @csrf
                                    <button class="btn btn-dark btn-sm">
                                        {{ auth()->user()->isFollowing($author) ? 'Unfollow' : 'Follow' }}
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                @endforeach
            </div>

            <hr class="my-4">
            @auth
                @if(($alreadyBought || $alreadyBorrowed) && !$alreadyReviewed)
                    <div class="review-form-card shadow-sm mb-4">
                        <h4>Write a Review</h4>

                        <form action="{{ route('review.store', $book->id) }}" method="POST">
                            @csrf

                            <div class="d-flex align-items-center mb-3">
                                <div class="star-rating-input me-3">
                                    <i class="star-input bi bi-star" data-value="1"></i>
                                    <i class="star-input bi bi-star" data-value="2"></i>
                                    <i class="star-input bi bi-star" data-value="3"></i>
                                    <i class="star-input bi bi-star" data-value="4"></i>
                                    <i class="star-input bi bi-star" data-value="5"></i>
                                </div>
                                <span id="rating-text" class="fw-semibold text-muted">
                                    Select rating
                                </span>
                            </div>

                            <input type="hidden" name="rating" id="rating-input" required>
                            <textarea  name="content" class="form-control stylish-textarea" rows="4" placeholder="Share your thoughts about this book..." required></textarea>

                            <button type="submit" class="submit-review-btn mt-3 w-100">
                                Submit Review
                            </button>

                        </form>

                    </div>
                    <hr class="my-4">            
                @endif
            @endauth
  
            <div class="reviews-section mt-5">
                <h3 class="fw-bold mb-4">Reviews</h3>
                @forelse ($book->reviews as $rev)
                    <div class="review-box d-flex mb-5">
                        <div class="review-user text-center me-4">
                            <img src="{{ asset('assets/default-avatar.png') }}" class="review-avatar mb-2" alt="User">
                            <div class="fw-bold">{{ $rev->user->name }}</div>

                            <div class="text-muted small">
                                {{ $rev->user->reviews()->count() }} reviews<br>
                                {{ $rev->user->followers_count ?? 0 }} followers
                            </div>

                            <button class="btn btn-dark btn-sm mt-2">Follow</button>
                        </div>

                        <div class="review-content flex-grow-1">
                            <div class="mb-1">
                                <span class="star-rating" style="--rating: {{ $rev->rating }};">★★★★★</span>
                                <small class="text-muted ms-2">{{ $rev->created_at->format('F d, Y') }}</small>
                            </div>

                            @php
                                $text = $rev->content;
                            @endphp

                            <div class="review-text short-text {{ strlen($text) > 300 ? 'fade-bottom' : '' }}">
                                {{ Str::limit($text, 300) }}
                            </div>

                            <div class="review-text full-text d-none">
                                {{ $text }}
                            </div>

                            @if(strlen($text) > 300)
                                <a href="javascript:void(0)" class="review-toggle toggle-link d-inline-flex align-items-center mt-1">
                                    <span class="label-text">Show more</span>
                                    <span class="ms-1 arrow">&#9662;</span>
                                </a>
                            @endif


                            <div class="mt-3 small text-muted">
                                <strong>1,457 likes · 216 comments</strong>
                            </div>

                        </div>
                    </div>
                    <hr>
                @empty
                    <p class="text-muted">No reviews yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

@section('custom-js')
    <script src="{{ asset('js/bookDetail.js') }}"></script>
@endsection

@endsection