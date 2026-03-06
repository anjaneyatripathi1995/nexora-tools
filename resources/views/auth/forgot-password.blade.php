@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<div class="auth-form">
    <h1>Reset password <span class="auth-h1-sub">Forgot your password?</span></h1>
    <p class="auth-subtitle">Enter your email and we'll send you a reset link.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="auth-ribbon">
            <div class="auth-ribbon-single">
                <x-text-input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Email" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-1" />

        <div class="block" style="margin-top: 1.25rem;">
            <x-primary-button class="w-100">{{ __('Email Password Reset Link') }}</x-primary-button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">Back to login</a>
    </div>
    <p class="auth-credit">Nexora Tools</p>
</div>
@endsection
