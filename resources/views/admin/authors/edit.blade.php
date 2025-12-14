@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>{{ __('authors.edit') }}</h2>

    <form action="{{ route('authors.update', $author->id) }}" method="POST" class="mt-3">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">{{ __('authors.name') }}</label>
            <input type="text" name="name" class="form-control" value="{{ $author->name }}">

            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-warning">{{ __('authors.update') }}</button>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">{{ __('authors.cancel') }}</a>
    </form>
</div>
@endsection
