<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item" aria-current="page"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        @if (request()->routeIs('create.blog'))
            <li class="breadcrumb-item"><a href="{{ route('create.blog') }}">Blog</a></li>
        @elseif(request()->routeIs('userView'))
            <li class="breadcrumb-item"><a href="{{ route('userView') }}">User</a></li>
        @elseif (request()->routeIs('admin.edit'))
            <li class="breadcrumb-item"><a href="{{ route('admin.edit') }}">Edit Profile</a></li>
        @endif
    </ol>
</nav>
