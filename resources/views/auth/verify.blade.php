@extends('layouts.app')

@section('title', 'Verification')

@section('content')
    <div class="container-form verify">
        <h1>{{ __('Verify Your Email Address') }}</h1>

                <div class="form-group">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('A fresh verification link has been sent to your email address.') }}
                        </div>
                    @endif
                      <p>
                        {{ __('Before proceeding, please check your email for a verification link.') }}
                        {{ __('If you did not receive the email') }}, <a class="btn-link"
                                                                         href="{{ route('verification.resend') }}">{{ __('click here to request another') }}</a></p>
                </div>
</div>
@endsection
