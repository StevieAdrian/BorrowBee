@extends('master.master')

@section('content')
<div class="container py-4">
    <h2>Transaction History</h2>

    <h4 class="mt-4">Purchased Books</h4>
    @if($transactions->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Purchased At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($transactions as $transaction)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $transaction->book->title }}</td>
                    <td>{{ $transaction->status }}</td>
                    <td>Rp {{ number_format($transaction->book->price, 0, ',', '.') }}</td>
                    <td>{{ $transaction->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No purchases yet.</p>
    @endif

    <h4 class="mt-4">Borrowed Books</h4>
    @if($borrowedBooks->count())
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Book</th>
                    <th>Borrowed At</th>
                    <th>Returned At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($borrowedBooks as $borrow)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $borrow->book->title }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('Y-m-d') }}</td>
                    <td>{{ $borrow->returned_at ? \Carbon\Carbon::parse($borrow->returned_at)->format('Y-m-d') : '-' }}</td>


                </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No borrowed books yet.</p>
    @endif
</div>
@endsection
