<!DOCTYPE html>
<html>
<head>
    <title>@yield('title', 'Super Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>

<body>

<div class="layout">

    {{-- SIDEBAR --}}
    @include('superadmin.partials.nav')

    {{-- MAIN CONTENT --}}
    <div class="main">

        <div class="topbar">
            <strong>{{ auth()->user()->email }}</strong>

            <a href="{{ route('logout') }}" class="logout">Logout</a>
        </div>

        @yield('content')

    </div>

</div>

</body>
</html>
