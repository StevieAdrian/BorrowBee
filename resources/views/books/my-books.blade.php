@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/myBook.css') }}">
@endsection

@section('content')

<div class="container my-5">
    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-warning">
        <h2 class="mb-0 text-uppercase" style="color:#FFB933;font-weight:900;letter-spacing: 1.5px;">{{ __('books.my_books') }}</h2>
    </div>
    
    <div class="mb-5">
        <ul class="nav nav-tabs border-0" id="myBooksTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active tab-custom" id="borrowed-tab" data-bs-toggle="tab" data-bs-target="#borrowed-books-pane" type="button" role="tab" aria-controls="borrowed-books-pane" aria-selected="true">
                    <i class="fas fa-book-reader me-2"></i> {{ __('books.borrowed_books') }}
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link tab-custom" id="purchased-tab" data-bs-toggle="tab" data-bs-target="#purchased-books-pane" type="button" role="tab" aria-controls="purchased-books-pane" aria-selected="false">
                    <i class="fas fa-shopping-bag me-2"></i> Purchased Library
                </button>
            </li>
        </ul>
    </div>

    <div class="tab-content" id="myBooksTabContent">

        <div class="tab-pane fade show active" id="borrowed-books-pane" role="tabpanel" aria-labelledby="borrowed-tab">
            <h4 class="mb-4 text-secondary">Current Loans ({{ $borrowedBooks->count() }})</h4>

            @if($borrowedBooks->isEmpty())
                <div class="alert alert-info bg-light text-muted border-0 shadow-sm">{{ __('books.empty') }}</div>
            @else
                <div class="row g-4">
                    @foreach($borrowedBooks as $bb)
                        @php
                            $book = $bb->book;
                            $due = \Carbon\Carbon::parse($bb->due_date);
                            $borrowedAt = \Carbon\Carbon::parse($bb->borrowed_at);
                            $daysLeft = $due->diffInDays(now(), false);
                            $badgeClass = $daysLeft < 0 ? 'bg-danger' : ($daysLeft <= 3 ? 'bg-warning' : 'bg-success');
                            $badgeText = $daysLeft < 0 ? 'OVERDUE' : ($daysLeft == 0 ? 'DUE TODAY' : $daysLeft . ' DAYS LEFT');
                            $cardBorder = $daysLeft < 0 ? 'border-danger' : ($daysLeft <= 3 ? 'border-warning' : 'border-light');
                        @endphp

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card card-hover h-100 shadow-sm {{ $cardBorder }}">
                                <div class="cover-wrapper">
                                    <img src="{{ $book->cover_url }}" class="card-img-top book-cover-fit" alt="{{ $book->title }} cover" onerror="this.src='{{ asset('assets/books/default.png') }}'">
                                    <span class="badge {{ $badgeClass }} text-uppercase badge-overlay">{{ $badgeText }}</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1 text-truncate fw-bold" title="{{ $book->title }}">{{ $book->title }}</h5>
                                    <p class="text-muted small mb-3">@if($book->authors->isNotEmpty()){{ $book->authors->pluck('name')->join(', ') }}@endif</p>
                                    <div class="d-flex justify-content-between small text-muted mb-2 border-top pt-2">
                                        <span>Borrowed: {{ $borrowedAt->format('d M Y') }}</span>
                                        <span class="fw-bold text-dark">
                                            Due: <span class="text-{{ Str::after($badgeClass, 'bg-') }}">{{ $due->format('d M Y') }}</span>
                                        </span>
                                    </div>
                                    <div class="mt-auto d-flex gap-2 pt-3">
                                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm flex-grow-1 btn-outline-warning btn-detail-hover">{{ __('books.details') }}</a>
                                        <form action="{{ route('return.book') }}" method="POST" class="d-inline">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">{{ __('books.return') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="tab-pane fade" id="purchased-books-pane" role="tabpanel" aria-labelledby="purchased-tab">
            <h4 class="mb-4 text-secondary">Your Permanent Library ({{ $transactions->count() }})</h4>

            @if($transactions->isEmpty())
                <div class="alert alert-light text-muted border-0 shadow-sm">You haven't purchased anything yet.</div>
            @else
                <div class="row g-4">
                    @foreach($transactions as $transaction)
                        @php
                            $book = $transaction->book;
                            $purchasedAt = \Carbon\Carbon::parse($transaction->created_at);
                            $isReviewed = in_array($book->id, $alreadyReviewed);
                        @endphp

                        <div class="col-12 col-md-6 col-lg-3">
                            <div class="card card-hover h-100 shadow-sm">
                                <div class="cover-wrapper">
                                    <img src="{{ $book->cover_url }}" class="card-img-top book-cover-fit" alt="{{ $book->title }} cover" onerror="this.src='{{ asset('assets/books/default.png') }}'">
                                    <span class="badge bg-primary badge-overlay">OWNED</span>
                                </div>
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-1 text-truncate fw-bold" title="{{ $book->title }}">{{ $book->title }}</h5>
                                    <p class="text-muted small mb-3">@if($book->authors->isNotEmpty()){{ $book->authors->pluck('name')->join(', ') }}@endif</p>
                                    <small class="text-muted mb-2 pt-2">Purchased on: <strong>{{ $purchasedAt->format('d M Y') }}</strong></small>
                                    <div class="mt-auto d-flex gap-2 pt-3">
                                        <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm flex-grow-1 btn-outline-warning btn-detail-hover">Details</a>
                                        @if(!$isReviewed)
                                            <a href="{{ route('review.create', $book->id) }}" class="btn btn-sm btn-success">Review</a>
                                        @else
                                            <button class="btn btn-sm btn-outline-secondary" disabled>Reviewed</button>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection