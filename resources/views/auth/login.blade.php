<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    {{-- Registro --}}
    @if (Route::has('register'))
        <div class="mt-6">
            <div class="relative flex items-center">
                <div class="flex-grow border-t border-gray-200"></div>
                <span class="mx-3 text-xs text-gray-400 flex-shrink">Ainda não tem conta?</span>
                <div class="flex-grow border-t border-gray-200"></div>
            </div>

            <a href="{{ route('register') }}"
               class="mt-4 flex items-center justify-center w-full gap-2 px-4 py-2.5 rounded-md
                      border-2 border-emerald-600 text-emerald-700 font-semibold text-sm
                      hover:bg-emerald-600 hover:text-white transition-all duration-200
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                🏆 Registre-se para jogar!
            </a>
        </div>
    @endif
</x-guest-layout>
