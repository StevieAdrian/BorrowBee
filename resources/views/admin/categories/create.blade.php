@extends('master.master')

@section('content')
<div class="container mt-4">
    <h2>{{ __('category.create') }}</h2>

    <form action="{{ route('categories.store') }}" method="POST" class="mt-3">
        @csrf

        <div class="mb-3">
            <label class="form-label">{{ __('category.title') }}</label>
            <input type="text" name="name" class="form-control" placeholder="{{ __('category.title') }} " value="{{ old('name') }}">

            @error('name')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">{{ __('category.save') }}</button>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">{{ __('category.cancel') }}</a>
    </form>
</div>
@endsection
