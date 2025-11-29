@extends('master.master')
@section('content')
    <div class="overlay"></div>
    <div class="d-flex flex-column justify-content-center align-items-center vh-100">
        <div class="mb-4 logo-bee">
            <img src="{{ asset('assets/borrowbee-logo.png') }}" width="80" alt="BorrowBee">
        </div>
        <div class="glass-box text-center">
            <h2>Register</h2>
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3 text-start">
                    <label class="form-label">Name</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{ old('name') }}">
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Email</label>
                    <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}">
                </div>
                <div class="mb-3 text-start">
                    <label class="form-label">Password</label>
                    <input id="password" type="password" name="password" class="form-control">
                </div>
                <div class="mb-4 text-start">
                    <label class="form-label">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" class="form-control">
                    @if ($errors->any())
                        <div class="text-danger text-start mb-2">
                            {{ $errors->first() }}
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-yellow w-50">Sign Up</button>
            </form>
        </div>
    </div>

    <script src="{{ asset('js/registerValidate.js') }}"></script>
@endsection
