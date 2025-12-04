<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>BorrowBee</title>
    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.8-dist/css/bootstrap.min.css') }}">
    @yield('custom-css')
</head>

<body>
    @if (!request()->routeIs(['login*', 'register*']))
        @include('master.navbar')
    @endif
    @if (session('error'))
        @include('components.toastr', ['type' => 'error', 'message' => session('error')])
    @endif
    @if (session('success'))
        @include('components.toastr', ['type' => 'success', 'message' => session('success')])
    @endif
    <main class="flex-grow-1 d-flex flex-column {{ request()->routeIs(['login', 'register']) ? '' : 'mt-5' }}">
        @yield('content')
    </main>
    @if (!request()->routeIs(['login*', 'register*']))
        @include('master.footer')
    @endif
    @yield('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const toastElList = [].slice.call(document.querySelectorAll('.toast'));
            toastElList.forEach(function(toastEl) {
                const toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        });
    </script>
    <script src="{{ asset('bootstrap-5.3.8-dist/js/bootstrap.bundle.min.js') }}"></script>
    @yield('custom-js')
</body>

</html>
