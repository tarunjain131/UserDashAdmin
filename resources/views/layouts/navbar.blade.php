<nav class="navbar navbar-light navbar-expand-lg bg-light">
    <div class="container">
        <a class="navbar-brand mr-auto" href="#">CompanyName</a>
        <div class="d-flex justify-content-end">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">


                    @if (!Auth::check())
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('login') }}">Login</a><span>&nbsp; &nbsp;</span>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-secondary" href="{{ route('register') }}">Register</a>
                        </li>
                    @else
                        @if (auth()->user()->role == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle dropdown-toggle-split" href="#" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Welcome {{ auth()->user()->name }}!
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('dashboard') }}">Dashboard</a></li>
                                    {{-- <li><a class="dropdown-item" id="dashboard">Dashboard</a></li> --}}
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('admin.edit') }}">Edit Profile</a></li>
                                    {{-- <li><a class="dropdown-item" id="editProfile">Edit Profile</a></li> --}}
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}">Logout</a></li>
                                    {{-- <li><a class="dropdown-item" id="logout">Logout</a></li> --}}
                                </ul>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="btn btn-secondary" href="{{ route('logout') }}">Logout</a>
                            </li>
                        @endif
                    @endif
                </ul>
            </div>
        </div>
    </div>
</nav>

@if (Auth::check())
    @if (auth()->user()->role == 1)
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                @if (request()->routeIs('show.blog'))
                    <li class="breadcrumb-item"><a href="{{ route('show.blog') }}">Blog</a></li>
                @elseif(request()->routeIs('userView'))
                    <li class="breadcrumb-item"><a href="{{ route('userView') }}">User</a></li>
                @elseif (request()->routeIs('admin.edit'))
                    <li class="breadcrumb-item"><a href="{{ route('admin.edit') }}">Edit Profile</a></li>
                @endif
            </ol>
        </nav>
    @endif
@endif
