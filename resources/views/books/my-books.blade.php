@extends('master.master')

@section('content')

<div class="container mt-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h2 class="mb-0" style="color:#FFB933;font-weight:700;">{{ __('books.my_books') }}</h2>
        <small class="text-muted">{{ auth()->user()->name ?? '' }}</small>
    </div>

    <div class="mb-4">
        <h4 class="mb-3" style="color:#343a40;">{{ __('books.borrowed_books') }}</h4>

        @if($borrowedBooks->isEmpty())
            <div class="alert alert-light text-muted">{{ __('books.empty') }}</div>
        @else
            <div class="row g-3">
                @foreach($borrowedBooks as $bb)
                    @php
                        $book = $bb->book;
                        $due = \Carbon\Carbon::parse($bb->due_date);
                        $borrowedAt = \Carbon\Carbon::parse($bb->borrowed_at);
                        $daysLeft = $due->diffInDays(now(), false);
                        $badgeClass = $daysLeft < 0 ? 'danger' : ($daysLeft <= 3 ? 'warning' : 'success');
                    @endphp

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div style="height:200px;overflow:hidden;">
                                <img src="{{ $book->cover_url }}" class="card-img-top w-100" alt="{{ $book->title }} cover" style="height:100%;object-fit:cover;" onerror="this.src='{{ asset('assets/books/default.png') }}'">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title mb-1">{{ $book->title }}</h5>
                                <p class="text-muted small mb-2">@if($book->authors->isNotEmpty()){{ $book->authors->pluck('name')->join(', ') }}@endif</p>

                                <div class="mb-2">
                                    <span class="badge bg-{{ $badgeClass }} me-2">{{ $due->format('d M Y') }}</span>
                                    <small class="text-muted">{{ __('books.borrowed_at') }}: {{ $borrowedAt->format('d M Y') }}</small>
                                </div>

                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm" style="background:#FFB933;color:white;">{{ __('books.details') }}</a>

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

    <div class="mb-5">
        <h4 class="mb-3" style="color:#343a40;">Purchased Books</h4>

        @if($transactions->isEmpty())
            <div class="alert alert-light text-muted">You haven't purchased anything.</div>
        @else
            <div class="row g-3">
                @foreach($transactions as $transaction)
                    @php
                        $book = $transaction->book;
                        $purchasedAt = \Carbon\Carbon::parse($transaction->created_at);
                    @endphp

                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card h-100 shadow-sm">
                            <div style="height:200px;overflow:hidden;">
                                <img src="{{ $book->cover_url }}" class="card-img-top w-100" alt="{{ $book->title }} cover" style="height:100%;object-fit:cover;" onerror="this.src='{{ asset('assets/books/default.png') }}'">
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="mb-1">{{ $book->title }}</h6>
                                <p class="text-muted small mb-2">{{ $purchasedAt->format('d M Y') }}</p>
                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-sm" style="background:#FFB933;color:white;">Details</a>
                                    @if(!in_array($book->id, $alreadyReviewed))
                                        <a href="{{ route('review.create', $book->id) }}" class="btn btn-sm btn-success">{{ __('books.review') ?? 'Review' }}</a>
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

@endsection
