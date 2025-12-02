@extends('master.master')

@section('content')

<form method="POST" action="{{ route('otp.verify') }}">
    @csrf
    <input type="text" name="otp" placeholder="Enter OTP" required>
    <button type="submit">Verify</button>
</form>


@endsection
