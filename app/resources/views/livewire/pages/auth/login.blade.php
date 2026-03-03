<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    public function login(): void
    {
        $this->validate();
        $this->form->authenticate();
        Session::regenerate();
        $default = auth()->user()->isAdmin()
            ? route('admin.dashboard', absolute: false)
            : route('dashboard', absolute: false);
        $this->redirectIntended(default: $default, navigate: true);
    }
}; ?>

<div class="auth-form">
    <h1>Welcome! <span class="auth-h1-sub">Please login...</span></h1>
    <p class="auth-subtitle">Sign in to your TechHub account</p>

    <a href="#" class="auth-google-btn">
        <svg width="20" height="20" viewBox="0 0 24 24"><path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/><path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
        Continue with Google
    </a>

    <div class="auth-divider">
        <span class="auth-divider-line"></span>
        <span class="auth-divider-text">or</span>
        <span class="auth-divider-line"></span>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form wire:submit="login">
        <div class="auth-ribbon">
            <div class="auth-ribbon-single">
                <x-text-input wire:model="form.email" id="email" type="email" name="email" required autofocus autocomplete="username" placeholder="Email" />
            </div>
            <div class="auth-ribbon-single">
                <x-text-input wire:model="form.password" id="password" type="password" name="password" required autocomplete="current-password" placeholder="Password" />
            </div>
        </div>
        <x-input-error :messages="$errors->get('form.email')" class="mt-1" />
        <x-input-error :messages="$errors->get('form.password')" class="mt-1" />

        <div class="auth-options block">
            <label for="remember" class="inline-flex items-center cursor-pointer">
                <input wire:model="form.remember" id="remember" type="checkbox" name="remember">
                <span class="ms-2 text-sm">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate>Forgot your password? Click here.</a>
            @endif
        </div>

        <div class="block">
            <x-primary-button class="w-100">Log in</x-primary-button>
        </div>
    </form>

    <div class="auth-links">
        <a href="#">Use single sign-on</a>
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" wire:navigate>Reset password</a>
        @endif
        <p class="auth-links-row"><span class="auth-links-muted">No account? </span><a href="{{ route('register') }}" wire:navigate>Create one</a></p>
    </div>
    <p class="auth-credit">TechHub</p>
</div>
