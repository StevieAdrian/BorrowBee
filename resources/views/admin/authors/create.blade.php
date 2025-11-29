@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>Create Author</h2>

    <form action="{{ route('authors.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">Author Name</label>
            <input type="text" name="name" class="form-control" placeholder="Enter author name">

            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Save</button>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
