@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <div class="container-form">

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <h1>{{ __('Register') }}</h1>
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

                @error('email')
                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                <input id="password"
                       type="password"
                       class="form-control @error('password') is-invalid @enderror"
                       name="password"
                       required
                       autocomplete="new-password">

                @error('password')
                <span class="invalid-feedback" role="alert">
                                                  <strong>{{ $message }}</strong>
                                              </span>
                @enderror
            </div>

            <div class="form-group row">
                <label for="password-confirm"
                       class="col-md-4 col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                <input id="password-confirm"
                       type="password"
                       class="form-control"
                       name="password_confirmation"
                       required
                       autocomplete="new-password">
            </div>

            <div class="form-group row mb-0">
                <div style="margin: 0 auto">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Register') }}
                    </button>
                    <p>Or</p>
                    <a href="login/github" class="btn btn-primary">
                        Login with GitHub
                    </a>
                    <div class="g-recaptcha" data-sitekey={{env('CAPTCHA_KEY')}}></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span>
                    <strong>
                        {{$errors->first('g-recaptcha-response')}}
                    </strong>
                </span>
                    @endif
                </div>
            </div>
        </form>
    </div>
@endsection
