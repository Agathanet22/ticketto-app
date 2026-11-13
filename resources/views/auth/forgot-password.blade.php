@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')
    <div class="auth-forgot-password-text">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    @if (session('status'))
        <div class="mb-4 font-medium text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="auth-form-group">
            <label for="email" class="auth-label">{{ __('Email') }}</label>
            <input id="email" class="auth-input @error('email') is-invalid @enderror" type="email" name="email" value="{{ old('email') }}" required autofocus />
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="auth-form-group">
            <button type="submit" class="auth-submit-button">
                {{ __('Confirm') }}
            </button>
        </div>
    </form>
@endsection