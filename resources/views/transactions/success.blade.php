@extends('master.master')

@section('content')
<div class="container py-4 text-center">
    <h2>Payment Successful!</h2>
    <p>Your purchase has been completed.</p>
    <a href="{{ route('home') }}" class="btn btn-primary">Back to Home</a>
</div>
@endsection
