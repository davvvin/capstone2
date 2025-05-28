<x-guest-layout>
    
    <x-slot name="title">Login Aplikasi</x-slot> {{-- Contoh mengirim judul --}}

    <div class="flex flex-col items-center min-h-screen pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                {{-- Ganti dengan logo aplikasi Anda jika ada --}}
                <img class="h-16 w-auto mb-6" src="{{ asset('admin-template/assets/img/kaiadmin/logo_light.svg') }}" alt="{{ config('app.name', 'Laravel') }}">
            </a>
        </div>

        <div class="w-full sm:max-w-md px-6 py-8 bg-white shadow-xl overflow-hidden sm:rounded-lg">
            <h2 class="text-2xl font-bold text-center text-gray-700 mb-6">Login ke Akun Anda</h2>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                    type="password"
                                    name="password"
                                    required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end mt-6">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                            {{ __('Lupa password?') }}
                        </a>
                    @endif

                    <x-primary-button class="ms-4 px-6 py-2">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            @if (Route::has('register'))
                <p class="text-sm text-center text-gray-600 mt-6">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-medium text-indigo-600 hover:text-indigo-500">
                        Daftar di sini
                    </a>
                </p>
            @endif
        </div>
    </div>
</x-guest-layout>
