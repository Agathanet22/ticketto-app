@extends('layouts.auth')

@section('title', 'Login')

@section('content')
    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="auth-form-group">
            <label for="email" class="auth-label">{{ __('Email') }}</label>
            <input id="email" class="auth-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-form-group">
            <label for="password" class="auth-label">{{ __('Password') }}</label>
            <input id="password" class="auth-input @error('password') is-invalid @enderror" type="password" name="password" required autocomplete="current-password" />
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-remember-me">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me" class="text-sm">{{ __('Remember me') }}</label>
        </div>

        <div class="auth-form-group">
            <button type="submit" class="auth-submit-button">
                {{ __('Sign in') }}
            </button>
        </div>

        @if (Route::has('password.request'))
            <a class="auth-forgot-password-link" href="{{ route('password.request') }}">
                {{ __('Forgot your password?') }}
            </a>
        @endif
    </form>
@endsection