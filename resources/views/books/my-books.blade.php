@extends('master.master')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4" style="color:#FFB933;font-weight:700;">{{ __('books.my_books') }}</h2>
    <div class="card shadow-sm">
        <div class="card-header" style="background:#FFB933;color:white;">
            {{ __('books.borrowed_books') }}
        </div>
        <div class="card-body">
            @if($borrowedBooks->isEmpty())
                <p class="text-muted">{{ __('books.empty') }}</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr style="background:#FFF3CD;">
                            <th>{{ __('books.title') }}</th>
                            <th>{{ __('books.borrowed_at') }}</th>
                            <th>{{ __('books.due_date') }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($borrowedBooks as $bb)
                        <tr>
                            <td>{{ $bb->book->title }}</td>
                            <td>{{ $bb->borrowed_at }}</td>
                            <td>{{ $bb->due_date }}</td>
                            <td>
                                <a href="{{ route('books.show', $bb->book->id) }}" class="btn btn-sm" style="background:#FFB933;color:white;">{{ __('books.details') }}</a>

                                <form action="{{ route('return.book') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $bb->book->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger">{{ __('books.return') }}</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    <div class="card shadow-sm mt-4">
        <div class="card-header" style="background:#FFB933;color:white;">
            Purchased Books
        </div>
        <div class="card-body">
            @if($transactions->isEmpty())
                <p class="text-muted">You haven't purchased anything.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr style="background:#FFF3CD;">
                            <th>Title</th>
                            <th>Purchased At</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transactions as $transaction)
                        <tr>
                            <td>{{ $transaction->book->title }}</td>
                            <td>{{ $transaction->created_at }}</td>
                            <td>
                                <a href="{{ route('books.show', $transaction->book->id) }}" class="btn btn-sm" style="background:#FFB933;color:white;">Details</a>
                                @if(!in_array($transaction->book->id, $alreadyReviewed))
                                    <a href="{{ route('review.create', $transaction->book->id) }}" class="btn btn-sm btn-success"> Review </a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</div>

@endsection
