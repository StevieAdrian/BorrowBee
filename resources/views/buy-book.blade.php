@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/buybook.css') }}">
@endsection

@section('content')
<div class="container buy-book-container">
    <div class="row">
        
        <div class="col-md-8">
            <div class="book-buy-details">
                <div class="cover-image-container">
                    <img src="{{ $book->cover_url ?? asset('storage/' . $book->cover_image) }}" class="cover-image-buy" alt="{{ $book->title }} Cover">
                </div>
                
                <div class="book-info-section">
                    <h2>{{ $book->title }}</h2>
                    <div class="author">
                        by {{ $book->authors->pluck('name')->join(', ') }}
                    </div>
                    <div class="price">
                        Rp {{ number_format($book->price, 0, ',', '.') }}
                    </div>
                    
                    <div class="description-section">
                        <strong>Description:</strong>
                        <p>
                            {!! nl2br(e(Str::limit($book->description, 400))) !!}
                        </p>
                        
                        <div class="personal-use-note">
                            The purchase of this book is for <strong>personal use only</strong>. Any reproduction, distribution, or publicly display is <strong>strictly prohibited</strong>.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="cost-summary-card">
                <h4 class="fw-bold mb-3">Cost Summary</h4>
                
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                </div>
                
                <div class="summary-row">
                    <span>Estimated Tax</span>
                    <span>Rp 0</span>
                </div>
                
                <div class="summary-row total">
                    <span>Total</span>
                    <span>Rp {{ number_format($book->price, 0, ',', '.') }}</span>
                </div>

                <form action="{{ route('transactions.create') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                    <button type="submit" class="purchase-btn">Purchase</button>
                </form>
                
                <div class="cancel-btn-wrapper">
                    <a href="{{ route('books.show', $book->id) }}" class="cancel-btn">
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection