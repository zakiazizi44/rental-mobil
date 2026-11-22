<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }} - Login</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Lucide Icons -->
        <script src="https://unpkg.com/lucide@latest"></script>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-navy-950 via-navy-800 to-navy-600 px-4 py-8">
            <!-- Grid overlay -->
            <div class="hero-grid-bg pointer-events-none absolute inset-0" aria-hidden="true"></div>

            <!-- Glow accents -->
            <div class="pointer-events-none absolute -top-24 -left-24 h-96 w-96 rounded-full bg-navy-400/20 blur-3xl" aria-hidden="true"></div>
            <div class="pointer-events-none absolute -bottom-32 -right-24 h-96 w-96 rounded-full bg-navy-300/15 blur-3xl" aria-hidden="true"></div>

            <div class="card relative w-full max-w-md rounded-2xl p-8 shadow-2xl shadow-navy-950/40 sm:p-10">
                <!-- Branding -->
                <div class="mb-8 flex flex-col items-center text-center">
                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-br from-navy-600 to-navy-900 text-white shadow-lg shadow-navy-900/30">
                        <i data-lucide="car" class="h-7 w-7"></i>
                    </div>
                    <h1 class="mt-4 text-2xl font-extrabold tracking-tight text-navy-800">Rental<span class="text-navy-500">Mobil</span></h1>
                    <p class="mt-1 text-sm text-slate-500">Welcome back! Sign in to your account.</p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Email')" class="font-semibold text-navy-800" />
                        <div class="relative mt-1">
                            <i data-lucide="mail" class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                            <x-text-input id="email" class="input-field block w-full pl-9" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mt-4">
                        <x-input-label for="password" :value="__('Password')" class="font-semibold text-navy-800" />

                        <div class="relative mt-1">
                            <i data-lucide="lock" class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-slate-400"></i>
                            <x-text-input id="password" class="input-field block w-full pl-9"
                                            type="password"
                                            name="password"
                                            required autocomplete="current-password" />
                        </div>

                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="mt-4 flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-navy-600 shadow-sm focus:ring-navy-500" name="remember">
                            <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm font-medium text-navy-600 transition hover:text-navy-800" href="{{ route('password.request') }}">
                                {{ __('Forgot your password?') }}
                            </a>
                        @endif
                    </div>

                    <div class="mt-6">
                        <button type="submit" class="btn-primary w-full justify-center rounded-xl py-3">
                            {{ __('Log in') }}
                            <i data-lucide="arrow-right" class="ms-1 h-4 w-4"></i>
                        </button>
                    </div>
                </form>

                @if (Route::has('register'))
                    <p class="mt-6 text-center text-sm text-slate-500">
                        {{ __('Don\'t have an account?') }}
                        <a href="{{ route('register') }}" class="font-semibold text-navy-600 transition hover:text-navy-800">{{ __('Sign up') }}</a>
                    </p>
                @endif
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.lucide) {
                    lucide.createIcons();
                }
            });
        </script>
    </body>
</html>