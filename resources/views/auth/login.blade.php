<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="text-3xl font-bold text-gray-800 text-center mt-3">Login</h2>

    <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

   
      <div class="flex justify-center items-center mt-5 py-2">
            <div><a href="{{ url('/') }}">&#8592;Torna alla banca dati</a></div>
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
      </div>

        <div class="flex items-center justify-between mt-4">
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm"
                        name="remember">
                    <span class="ms-2 text-sm text-black-600 font-bold">{{ __('Ricordami') }}</span>
                </label>
            </div>
            @if (Route::has('password.request'))
                <a class="underline text-sm text-black-600 font-bold hover:text-gray-900 rounded-md"
                    href="{{ route('password.request') }}">
                    {{ __('Password dimenticata?') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
