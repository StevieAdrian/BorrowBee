<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-0">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
            <img src="{{ asset('assets/borrowbee-logo-2.png') }}" alt="logo" width="80" class="me-2 mt-2 align-self-center">
            <span class="fw-semibold">BorrowBee</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                @if (!Request::is('/'))
                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('home') }}">Home</a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="#">About Us</a>
                    </li>

                    <li class="nav-item mx-2">
                        <a class="nav-link" href="{{ route('mybooks') }}">My Books</a>
                    </li>
                @endif

                @include('master.lang.localization')
                
                @if (!Request::is('/'))
                    <li class="nav-item ms-3 dropdown">
                        <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                            @auth
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="60" height="60" style="object-fit: cover;" class="rounded-circle" alt="profile">
                                @else
                                    <img src="{{ asset('assets/default-pp.png') }}" width="60" class="rounded-circle" alt="profile">
                                @endif
                            @endauth
                            @guest
                                <img src="{{ asset('assets/default-pp.png') }}" width="60" class="rounded-circle" alt="profile">
                            @endguest
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Edit Profile</a></li>
                            @guest
                                <a class="dropdown-item" href="{{ route('login') }}"> Login</a>
                            @endguest
                            @auth
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"> Logout</a>
                            @endauth
                        </ul>
                    </li>

                @endif

                @if (Request::is('/'))
                    <li class="nav-item ms-3">
                        <a href="{{ route('register') }}" class="btn px-3" style="background-color: #FFE9A3; border:none; color:#000; font-weight:600;">Sign In</a>
                    </li>
                @endif

            </ul>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>