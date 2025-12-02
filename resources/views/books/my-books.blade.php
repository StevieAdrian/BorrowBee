@extends('master.master')

@section('content')

<div class="container mt-4">
    <h2 class="mb-4" style="color:#FFB933;font-weight:700;">My Books</h2>
    <div class="card shadow-sm">
        <div class="card-header" style="background:#FFB933;color:white;">
            Borrowed Books
        </div>
        <div class="card-body">
            @if($borrowedBooks->isEmpty())
                <p class="text-muted">You haven't borrowed anything.</p>
            @else
                <table class="table table-bordered">
                    <thead>
                        <tr style="background:#FFF3CD;">
                            <th>Title</th>
                            <th>Borrowed At</th>
                            <th>Due Date</th>
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
                                <a href="{{ route('books.show', $bb->book->id) }}" class="btn btn-sm" style="background:#FFB933;color:white;">Details</a>

                                <form action="{{ route('return.book') }}" method="POST" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $bb->book->id }}">
                                    <button type="submit" class="btn btn-sm btn-danger"> Return </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
        {{-- purchased books nnt bikin dsn --}}
    </div>
</div>

@endsection
