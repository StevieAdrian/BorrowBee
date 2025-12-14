<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm py-0 sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ Auth::check() && Auth::user()->role_id === 2 ? route('admin.dashboard') : route('home') }}">
            <img src="{{ asset('assets/borrowbee-logo-2.png') }}" alt="logo" width="80" class="me-2 mt-2 align-self-center">
            <span class="fw-semibold">BorrowBee</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-center">
                @auth
                    @if(Auth::user()->role_id === 2)
                        
                        <li class="nav-item mx-2">
                            <a class="nav-link fw-semibold" href="{{ route('admin.dashboard') }}">
                                Dashboard
                            </a>
                        </li>

                        @include('master.lang.localization')

                        <li class="nav-item ms-3 dropdown">
                            <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                                @if (Auth::user()->avatar)
                                    <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="55" height="55" style="object-fit: cover;" class="rounded-circle">
                                @else
                                    <img src="{{ asset('assets/default-pp.png') }}" width="55" class="rounded-circle">
                                @endif
                            </a>

                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('users.show', auth()->id()) }}">{{ __('navbar.view_profile') }}</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile') }}">{{ __('navbar.edit_profile') }}</a></li>
                                <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('navbar.logout') }}</a>
                            </ul>
                        </li>

                    @else

                    @if (!Request::is('/'))
                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('navbar.home') }}</a>
                        </li>

                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('mybooks') }}">{{ __('navbar.my_books') }}</a>
                        </li>

                        <li class="nav-item mx-2">
                            <a class="nav-link" href="{{ route('about') }}">{{ __('navbar.about') }}</a>
                        </li>
                    @endif

                    @include('master.lang.localization')

                    <li class="nav-item ms-3 dropdown">
                        <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                            @if (Auth::user()->avatar)
                                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" width="55" height="55" style="object-fit: cover;" class="rounded-circle">
                            @else
                                <img src="{{ asset('assets/default-pp.png') }}" width="55" class="rounded-circle">
                            @endif
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('users.show', auth()->id()) }}">View Profile</a></li>
                            <li><a class="dropdown-item" href="{{ route('profile') }}">Edit Profile</a></li>
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('navbar.logout') }}</a>
                        </ul>
                    </li>

                    @endif
                @endauth

                @guest
                    @include('master.lang.localization')

                    @if (Request::is('/'))
                        <li class="nav-item ms-3">
                            <a href="{{ route('register') }}" class="btn px-3" style="background-color: #FFE9A3; border:none; color:#000; font-weight:600;">{{ __('navbar.sign_in') }}</a>
                        </li>
                    @endif
                @endguest

            </ul>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>