@extends('master.master')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between mb-3">
        <h2>Books</h2>
        <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Price</th>
                <th>Availability</th>
                <th width="180px">Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach($books as $book)
                <tr>
                    <td>{{ $book->id }}</td>

                    <td>
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" width="60" height="80" class="rounded">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>

                    <td>{{ $book->title }}</td>
                    <td>{{ $book->category->name }}</td>
                    <td>{{ $book->author->name }}</td>

                    <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>

                    <td>
                        @if($book->is_available)
                            <span class="badge bg-success">Available</span>
                        @else
                            <span class="badge bg-danger">Not Available</span>
                        @endif
                    </td>

                    <td>
                        <a href="{{ route('books.edit', $book->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        <form action="{{ route('books.destroy', $book->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
