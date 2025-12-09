@extends('master.master')


@section('content')

<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div>
        <div>
            <img src="{{ asset('assets/home-banner.png') }}" class="d-block w-100" alt="Banner 2">
        </div>
    </div>

    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon"></span>
    </button>

    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon"></span>
    </button>
</div>

<div class="container py-4">
    <form id="filterForm" method="GET" action="{{ route('home') }}" class="row g-3 align-items-center">
        <div class="col-md-3">
            <select name="category_id" class="form-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Find Genre</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-3">
            <select name="sort" class="form-select" onchange="document.getElementById('filterForm').submit()">
                <option value="">Sort By Price</option>
                <option value="price_asc" {{ request('sort')=='price_asc'?'selected':'' }}>Price: Low to High</option>
                <option value="price_desc" {{ request('sort')=='price_desc'?'selected':'' }}>Price: High to Low</option>
            </select>
        </div>

        <div class="col-md-4">
            <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Search...">
        </div>

        <div class="col-md-2 d-grid">
            <button class="btn btn-warning">Search</button>
        </div>
    </form>
</div>

<div class="container pb-5">
    <div class="row g-4">
        @foreach($books as $book)
        <div class="col-md-3">
            <div class="card h-100 shadow-sm">
                <img src="{{ $book->cover_url }}" class="card-img-top" style="height: 300px; object-fit: cover">
                
                <div class="card-body">
                    <h5 class="card-title">{{ $book->title }}</h5>
                    <p class="card-text">Rp {{ number_format($book->price, 0, ',' , '.') }}</p>
                </div>

                <div class="card-footer bg-white">
                    <a href="{{ route('books.show', $book->id) }}" class="btn btn-warning w-100">Detail</a>
                </div>

            </div>
        </div>
        @endforeach

    </div>

    <div class="text-center mt-4">
        {{ $books->links('pagination::bootstrap-5') }}
    </div>
</div>

@endsection
