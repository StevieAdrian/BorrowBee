@extends('master.master')

@section('content')

<div class="position-relative" style="height: 100vh;">
    <img  src="{{ asset('assets/auth-background.jpg') }}" class="w-100 h-100 position-absolute top-0 start-0" style="object-fit: cover; filter: brightness(50%);" alt="Library Background">

    <div class="position-absolute top-50 start-50 translate-middle text-center text-white px-3" style="width: 100%;">
        <h1 class="fw-bold display-3">BorrowBee</h1>
        <p class="mt-3 fs-5">
            BorrowBee brings all your favorite e-books together in one organized, accessible, and user-friendly platform.
        </p>

        <a href="{{ route('home') }}" class="btn mt-3 px-4 py-2 fw-semibold" style="background-color:#FFE9A3; border:none; color:#000; font-weight:600;">
            Get Started
        </a>

    </div>
</div>

@endsection
