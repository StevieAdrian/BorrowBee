@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>{{ __('authors.create') }}</h2>

    <form action="{{ route('authors.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('authors.name') }}</label>
            <input type="text" name="name" class="form-control" placeholder="{{ __('authors.name_placeholder') }}" value="{{ old('name') }}">

            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ __('authors.save') }}</button>
        <a href="{{ route('authors.index') }}" class="btn btn-secondary">{{ __('authors.cancel') }}</a>
    </form>
</div>
@endsection
