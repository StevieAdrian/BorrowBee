@extends('master.master')

@section('content')

<div class="container mt-4">

    <div class="mb-4">
        <h2 class="fw-bold text-center">Books</h2>
    </div>

    <div class="bg-white p-4 rounded-4 shadow-sm">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="fw-bold mb-0">Books</h4>
            <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
        </div>

        <div class="text-end mb-3 fw-medium">
            Filter
        </div>

        <div class="table-responsive">
            <table class="table table-borderless align-middle">
                <thead class="bg-light">
                    <tr>
                        <th>ID</th>
                        <th>Cover</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Author</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($books as $book)
                        <tr class="bg-white shadow-sm rounded">
                            <td>{{ $book->id }}</td>

                            <td>
                                @if($book->cover_image)
                                    <img src="{{ $book->cover_image }}" width="60" height="80" class="rounded">
                                @else
                                    <span class="text-muted">No Image</span>
                                @endif
                            </td>

                            <td>{{ $book->title }}</td>

                            <td>
                                @foreach($book->categories as $c)
                                    <span class="badge bg-secondary me-1">{{ $c->name }}</span>
                                @endforeach
                            </td>

                            <td>
                                @foreach($book->authors as $a)
                                    <span class="badge bg-info me-1">{{ $a->name }}</span>
                                @endforeach
                            </td>

                            <td>Rp {{ number_format($book->price, 0, ',', '.') }}</td>

                            <td>
                                @if($book->is_available)
                                    <span class="badge bg-success px-3 py-2">Available</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">Not Available</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('books.edit', $book->id) }}" 
                                       class="btn btn-warning btn-sm rounded-3">
                                        ✏️
                                    </a>

                                    <form action="{{ route('books.destroy', $book->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm rounded-3"
                                            onclick="return confirm('Delete this book?')">
                                            🗑️
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
