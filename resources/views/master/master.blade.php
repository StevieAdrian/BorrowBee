<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>BorrowBee</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>

<body>
    {{-- @include('components.navbar') --}}
    <main class="flex-grow-1 d-flex flex-column {{ request()->routeIs(['login', 'register']) ? '' : 'mt-5' }}">
        @yield('content')
    </main>
    {{-- @if (!request()->routeIs(['login', 'register']))
        @include('components.footer')
    @endif --}}
    @yield('scripts')
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
