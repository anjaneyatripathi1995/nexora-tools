@extends('layouts.guest')

@section('title', 'Verify Email')

@section('content')
<div class="auth-form">
    <h1>Verify email <span class="auth-h1-sub">Almost there</span></h1>
    <p class="auth-subtitle">{{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}</p>

    @if (session('status') == 'verification-link-sent')
        <div style="color: #34d399; font-size: 0.9rem; margin-bottom: 1rem;">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="block">
        <form method="POST" action="{{ route('verification.send') }}" style="margin-bottom: 1rem;">
            @csrf
            <x-primary-button class="w-100">{{ __('Resend Verification Email') }}</x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="auth-links-row" style="background: none; border: none; color: rgba(255,255,255,0.85); cursor: pointer; font-size: 0.875rem; text-decoration: underline;">
                {{ __('Log Out') }}
            </button>
        </form>
    </div>

    <div class="auth-links">
        <a href="{{ route('dashboard') }}">Go to Dashboard</a>
    </div>
    <p class="auth-credit">Nexora Tools</p>
</div>
@endsection
