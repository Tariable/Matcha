@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <div class="container-form">
    <form method="POST" action="{{ route('login') }}">
      @csrf

{{--      <div class="form-group alert">--}}


{{--      </div>--}}
      <h1>Login</h1>

      <div class="form-group row">
{{--        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>--}}
{{----}}
          <input id="email"
                 type="email"
                 class="form-control @error('email') is-invalid @enderror"
                 name="email"
                 value="{{ old('email') }}"
                 required
                 autocomplete="email"
                 placeholder="E-Mail Address"
                 autofocus>
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
      </div>

      <div class="form-group row">
{{--        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>--}}
          <input id="password"
                 type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 name="password"
                 required
                 placeholder="Password"
                 autocomplete="current-password">

        @error('password')

        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror

      </div>

<p>{{ auth()->user() }}</p>
      <div class="form-group check">
            <input class="form-check-input"
                   type="checkbox"
                   name="remember"
                   id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="form-check-label" for="remember">
              {{ __('Remember Me') }}
            </label>
      </div>

      <div class="form-group col">
        <div>
          <button type="submit" class="btn btn-primary">
            {{ __('Login') }}
          </button>
            <a href="login/github" class="btn btn-primary">
                Login with GitHub
            </a>
        </div>

        <div class="mt-10"> @if (Route::has('password.request'))
            <a class="btn-link" href="{{ route('password.request') }}">
              {{ __('Forgot Your Password?') }}
            </a>
          @endif</div>
      </div>
    </form>
  </div>
@endsection
