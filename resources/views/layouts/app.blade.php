<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="auth_id" content="{{ auth()->id() }}">


    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="{{ asset('js/ion.rangeSlider.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Icons -->
    <script src="https://kit.fontawesome.com/a85f6d1cce.js"></script>
    <!-- Styles -->

    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    {{--  <link href="{{ asset('css/ap3p.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="{{ asset('css/ion.rangeSlider.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://necolas.github.io/normalize.css/8.0.1/normalize.css">
    {{--  <link href="{{ asset('css/ap3p.css') }}" rel="stylesheet">--}}
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link href="{{ asset('css/ion.rangeSlider.css') }}" rel="stylesheet">
    {{--  Favicon--}}
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
</head>
<body>

<nav class="navbar">
    <div class="container">
        <div class="logo">
            <a class="navbar-brand .nav-link" href="{{ url('/recs') }}"><i class="fas fa-heart"></i>
                {{ config('app.name') }}
            </a>
        </div>
        <ul class="navbar-nav">
            <!-- Authentication Links -->
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                </li>
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <div id="app">
                    <li class="nav-item">
                        <notification :user="{{ auth()->user() }}"></notification>
                    </li>
                </div>
                <li class="nav-item drop-container">
                    <i class="fa fa-gear"></i><span class="arrow"> ▼</span>
                    <ul class="dropdown">
                        <li class="dropdown-item"><a href="/messages" class="nav-link">Messages</a></li>
                        <li class="dropdown-item"><a href="/profiles/edit" class="nav-link">Edit profile</a></li>
                        <li class="dropdown-item"><a href="/preferences/edit" class="nav-link">Edit preferences</a>
                        </li>
                        <li class="dropdown-item"><a class="nav-link" href="{{ route('logout') }}"
                                                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                  style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            @endguest
        </ul>
    </div>
</nav>
<p id="myId" hidden>{{ Auth::id() }}</p>

<main class="py-4">
    @yield('content')
</main>

</body>
<script src="{{ URL::asset('js/Navbar/navbar.js') }}"></script>
<script src="{{ asset('js/app.js') }}"></script>
</html>
