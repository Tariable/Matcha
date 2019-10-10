@extends('layouts.app')

@section('title', 'Reset password')

@section('content')
  <div class="container-form">
          <div class="card-body" style="visibility: visible">
          @if (session('status'))
              <div class="alert alert-success mb-10" role="alert">
                {{ session('status') }}
              </div>
            @endif
            <form method="POST" action="{{ route('password.email') }}">
              <h1>{{ __('Reset Password') }}</h1>

              @csrf
              <div class="form-group row">
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="E-Mail Address" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                  @error('email')
                  <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                  @enderror
              </div>

              <div class="form-group row" style="align-items: center">
                <div class="login-buttons">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Reset') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
    </div>
  </div>
@endsection
