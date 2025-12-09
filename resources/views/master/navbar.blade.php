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
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('home') }}">Home</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="#">About Us</a>
                </li>

                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('mybooks') }}">My Books</a>
                </li>

                @include('master.lang.localization')
                
                <li class="nav-item mx-2">
                    <a class="nav-link" href="{{ route('history') }}">History</a>
                </li>

                <li class="nav-item ms-3 dropdown">
                    <a href="#" class="d-flex align-items-center" data-bs-toggle="dropdown">
                        <img src="{{ asset('assets/default-pp.png') }}" width="60" class="rounded-circle" alt="profile">
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

            </ul>
        </div>
    </div>
</nav>

<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
    @csrf
</form>