@extends('master.master')

@section('custom-css')
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
    <div class="overlay"></div>
    <div class="container-fluid h-100 d-flex align-items-center vh-100">
        <div class="row w-100">
            <div class="col-md-6 d-flex flex-column justify-content-center ps-5 login-left-text">
                <h1>WELCOME<br>BACK</h1>
                <p>BorrowBee brings all your favorite e-books together in one organized, accessible, and user-friendly platform.</p>
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="glass-box text-center">
                    <h2 class="mb-4 text-white">Sign Up</h2>
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="mb-3 text-start">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="mb-3 text-start">
                            <label class="form-label">Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        @if ($errors->any())
                            <div class="text-danger text-start mb-3">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <button type="submit" class="btn btn-yellow w-50">Sign Up</button>
                        <p class="mt-3 text-white">
                            Don't have an account?
                            <a href="{{ route('register') }}" class="text-warning fw-bold text-decoration-none">Sign Up</a>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
