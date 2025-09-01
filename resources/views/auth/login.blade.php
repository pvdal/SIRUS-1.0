<x-guest-layout>
    <x-slot name="title">
        Login
    </x-slot>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo size="60"/>
        </x-slot>

        <x-validation-errors class="mb-4" />

        @session('status')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ $value }}
            </div>
        @endsession

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            </div>

            <div class="mt-4 relative max-h-24">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                <button id="showPass" type="button"
                        class="absolute right-[2px] top-[26px] flex w-9 h-[38px] items-center justify-center rounded-s-sm rounded-e-md hover:bg-gray-100 dark:hover:bg-gray-100">
                    <x-lucide-eye id="icoShow" class="h-4 w-4 text-gray-700" />
                    <x-lucide-eye-off id="icoHide" class="h-4 w-4 hidden" />
                </button>
            </div>

            <div class="block mt-4">
                <label for="remember_me" class="flex items-center">
                    <x-checkbox id="remember_me" name="remember" />
                    <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif

                <x-button class="ms-4">
                    {{ __('Log in') }}
                </x-button>
            </div>
        </form>
    </x-authentication-card>
    @push('scripts')
        <script>
            const input   = document.getElementById('password');
            const btn     = document.getElementById('showPass');
            const icoShow = document.getElementById('icoShow'); // olho
            const icoHide = document.getElementById('icoHide'); // olho cortado

            btn.addEventListener('click', () => {
                const showing = input.type === 'text';
                input.type = showing ? 'password' : 'text';

                // alterna os ícones
                icoShow.classList.toggle('hidden', !showing);
                icoHide.classList.toggle('hidden', showing);
            });
        </script>
    @endpush
</x-guest-layout>
