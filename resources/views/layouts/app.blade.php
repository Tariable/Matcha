<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name') }}</title>

  <!-- Scripts -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="{{ asset('js/ion.rangeSlider.js') }}"></script>
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
</head>
<body>

{{--<div id="app">--}}
  <nav class="navbar">
    <div class="container">
      <div class="logo">
        <a class="navbar-brand .nav-link" href="{{ url('/') }}"><i class="fas fa-heart"></i>
          {{ config('app.name') }}
        </a>
      </div>

{{--      <button class="navbar-toggler"--}}
{{--                type="button"--}}
{{--                data-toggle="collapse"--}}
{{--                data-target="#navbarSupportedContent"--}}
{{--                aria-controls="navbarSupportedContent"--}}
{{--                aria-expanded="false"--}}
{{--                aria-label="{{ __('Toggle navigation') }}">--}}
{{--          <span class="navbar-toggler-icon"></span>--}}
{{--        </button>--}}


        <ul class="navbar-nav ml-auto">
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
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                  {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
            </li>
          @endguest
        </ul>
    </div>
  </nav>

  <main class="py-4">
    <div id="app">
      @yield('content')
    </div>
  </main>
{{--</div>--}}
</body>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
</html>
