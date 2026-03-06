@extends('layouts.guest')

@section('title', 'Reset Password')

@section('content')
<div class="auth-form">
    <h1>Set new password <span class="auth-h1-sub">Reset your account</span></h1>
    <p class="auth-subtitle">Enter your new password below.</p>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="auth-ribbon">
            <div class="auth-ribbon-single">
                <x-text-input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" placeholder="Email" />
            </div>
            <div class="auth-ribbon-single">
                <x-text-input id="password" type="password" name="password" required autocomplete="new-password" placeholder="New Password" />
            </div>
            <div class="auth-ribbon-single">
                <x-text-input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm Password" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('email')" class="mt-1" />
        <x-input-error :messages="$errors->get('password')" class="mt-1" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />

        <div class="block" style="margin-top: 1.25rem;">
            <x-primary-button class="w-100">{{ __('Reset Password') }}</x-primary-button>
        </div>
    </form>

    <div class="auth-links">
        <a href="{{ route('login') }}">Back to login</a>
    </div>
    <p class="auth-credit">Nexora Tools</p>
</div>
@endsection
