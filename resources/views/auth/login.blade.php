<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-gray-700 font-medium" />
            <x-text-input id="email" class="block mt-2 w-full bg-white border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-shadow hover:border-gray-300" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-medium" />

            <x-text-input id="password" class="block mt-2 w-full bg-white border-gray-200 text-gray-900 focus:border-brand-500 focus:ring-brand-500 rounded-xl shadow-sm transition-shadow hover:border-gray-300"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-500 shadow-sm focus:ring-brand-500 w-4 h-4 cursor-pointer transition-colors" name="remember">
                <span class="ms-2 text-sm text-gray-600 group-hover:text-gray-900 transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col sm:flex-row sm:items-center justify-between mt-8 gap-4">
            @if (Route::has('password.request'))
                <a class="text-sm text-brand-600 hover:text-brand-500 font-medium transition-colors focus:outline-none focus:underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="w-full sm:w-auto justify-center px-8 py-3 bg-brand-500 hover:bg-brand-600 focus:bg-brand-600 active:bg-brand-700 rounded-xl shadow-lg shadow-brand-500/30 transition-all hover:shadow-brand-500/40 hover:-translate-y-0.5">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
