@extends('master.master')

@section('content')
    <div class="container py-4">
        <a href="{{ isset($_GET['from']) ? route('books.show', $_GET['from']) : url()->previous() }}" class="btn btn-secondary mb-3">
            Back
        </a>


        <div class="d-flex mb-4">
            <img src="{{ asset('assets/default-avatar.png') }}" 
                class="rounded me-3" width="120">

            <div>
                <h2 class="fw-bold">{{ $author->name }}</h2>
                <p class="text-muted">
                    {{ $author->followers_count ?? 0 }} followers
                </p>

                @auth
                    <form action="{{ route('author.follow', $author->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-dark">
                            {{ auth()->user()->isFollowing($author) ? 'Unfollow' : 'Follow' }}
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        <hr>

        <h3 class="fw-bold mb-3">Books by {{ $author->name }}</h3>

        <div class="row">
            @forelse($books as $book)
                <div class="col-md-3 mb-4">
                    <a href="{{ route('books.show', $book->id) }}" class="text-decoration-none text-dark">
                        <div class="card shadow-sm">
                            <img src="{{ $book->cover_url }}" class="card-img-top">
                            <div class="card-body">
                                <h5 class="card-title">{{ $book->title }}</h5>

                                @foreach($book->categories as $cat)
                                    <span class="badge bg-light text-dark border">{{ $cat->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <p class="text-muted">This author has no books listed.</p>
            @endforelse
        </div>
    </div>
@endsection
