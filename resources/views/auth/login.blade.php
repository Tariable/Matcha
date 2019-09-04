@extends('layouts.app')

@section('content')
  <div class="container-form">

    <form method="POST" action="{{ route('login') }}">
      @csrf

      <div class="form-group alert">
        @error('email')
        <span class="invalid-feedback" role="alert" >
                                                    <strong>{{ $message }}</strong>
                                                </span>
        @enderror
        @error('password')

        <span class="invalid-feedback" role="alert" >
                                                    <strong>{{ $message }}</strong>
                                                </span>
        @enderror
      </div>
      <div class="form-group row">
        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

          <input id="email"
                 type="email"
                 class="form-control @error('email') is-invalid @enderror"
                 name="email"
                 value="{{ old('email') }}"
                 required
                 autocomplete="email"
                 autofocus>


      </div>

      <div class="form-group row">
        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>
          <input id="password"
                 type="password"
                 class="form-control @error('password') is-invalid @enderror"
                 name="password"
                 required
                 autocomplete="current-password">



      </div>


      <div class="form-group check">
{{--        <div></div>--}}
{{--          <div class="form-check">--}}
            <input class="form-check-input"
                   type="checkbox"
                   name="remember"
                   id="remember" {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
              {{ __('Remember Me') }}
            </label>
{{--          </div>--}}
      </div>

      <div class="form-group col">
        <div>
          <button type="submit" class="btn btn-primary nav-link">
            {{ __('Login') }}
          </button>
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
