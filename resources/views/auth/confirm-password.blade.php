@extends('layouts.guest')

@section('title', 'Confirm Password')

@section('content')
<div class="auth-form">
    <h1>Confirm password <span class="auth-h1-sub">Secure area</span></h1>
    <p class="auth-subtitle">{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <div class="auth-ribbon">
            <div class="auth-ribbon-single">
                <x-text-input id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-1" />

        <div class="block" style="margin-top: 1.25rem;">
            <x-primary-button class="w-100">{{ __('Confirm') }}</x-primary-button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('dashboard') }}">Back to Dashboard</a>
    </div>
    <p class="auth-credit">Nexora Tools</p>
</div>
@endsection
