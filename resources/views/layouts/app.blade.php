<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="icon" href="/favicon.ico" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'The Mobis: Reloaded') }} - @yield('title')</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>
</head>

<body>
    <div id="app">
        <nav class="nav">
            <div class="nav-left">
                <a class="nav-item" href="/">
                    <img src="/mobis-reloaded.png" alt="The Mobis: Reloaded Logo">
                </a>
            </div>

            <div class="nav-center">
                <a class="nav-item">
                    <span class="icon">
                        <i class="fa fa-github"></i>
                    </span>
                </a>
            </div>

            <span class="nav-toggle">
                <span></span>
                <span></span>
                <span></span>
            </span>

            <div class="nav-right nav-menu">
                @if (Auth::guest())
                    <a class="nav-item" href="{{ route('login') }}">Login</a>
                    <a class="nav-item" href="{{ route('register') }}">Register</a>
                @elseif (Auth::check())
                    <a class="nav-item" href="/users/">Leader Board</a>
                    <a class="nav-item" href="/quiz/">Quiz</a>
                    <a class="nav-item" href="/users/{{ Auth::user()->id }}">Profile</a>
                    <a class="nav-item" href="/logout">Log Out</a>
                @endif
            </div>
        </nav>
        <div class="container">
        @yield('content')
        </div>
    </div>
    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
