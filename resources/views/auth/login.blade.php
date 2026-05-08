<x-guest-layout>
    <x-slot name="title">
        Login
    </x-slot>
    <x-authentication-card>
        <x-slot name="logo">
            <div class="flex justify-center">
                <a href="{{ route('home') }}">
                    <x-application-logo
                        size="60"
                        class="block dark:hidden"
                    />

                    <x-authentication-card-logo
                        size="60"
                        class="hidden dark:block"
                    />
                </a>
            </div>
        </x-slot>

        <div class="flex flex-col items-center mb-10">
            <h1 class="text-center text-2xl xl:text-3xl font-semibold text-gray-800 dark:text-white">
                Faça login para continuar
            </h1>
            <h2 class="text-center text-base xl:text-lg text-gray-500 dark:text-gray-400">
                Insira suas credenciais
            </h2>
        </div>

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
                <x-input
                    id="email"
                    class="block mt-1 w-full dark:border-gray-500 dark:bg-gray-900/50"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required autofocus autocomplete="username"
                    placeholder="seu@email.com"/>
            </div>

            <div class="mt-6 relative max-h-24">
                <x-label for="password" value="{{ __('Password') }}" />
                <x-input
                    id="password"
                    class="block mt-1 w-full dark:border-gray-500 dark:bg-gray-900/50"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    placeholder="Digite sua senha" />
                <button id="showPass" type="button"
                        class="absolute right-[2px] top-[26px] flex w-9 h-[38px] items-center justify-center rounded-s-sm rounded-e-md hover:bg-gray-100 dark:hover:bg-gray-700">
                    <x-lucide-eye id="icoShow" class="h-4 w-4 text-gray-700 dark:text-gray-300" />
                    <x-lucide-eye-off id="icoHide" class="h-4 w-4 hidden" />
                </button>
            </div>
            <div class="flex flex-wrap gap-2 mt-6">
                @if(config('fortify.manage-sessions'))
                    <label for="remember_me" class="flex items-center mb-2">
                        <x-checkbox id="remember_me" name="remember" />
                        <span class="ms-2 text-sm text-gray-800 dark:text-gray-300">{{ __('Remember me') }}</span>
                    </label>
                @endif
                @if (Route::has('password.request'))
                    <a class="ms-auto text-gray-800 dark:text-gray-300 text-sm font-semibold hover:underline hover:text-gray-950 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <div class="flex items-center justify-end mt-8">
                <x-button class="w-full py-3">
                    <span class="text-sm">{{ __('Log in') }}</span>
                </x-button>
            </div>
        </form>
        <div class="flex flex-col">
            <div class="py-6">
                <div class="border-t border-gray-200 dark:border-gray-600 transition duration-150 ease-in-out"></div>
            </div>
            <div class="text-sm text-center text-gray-500 dark:text-gray-400">
                Ao continuar, você concorda com nossos
                <a target="_blank"
                   href="{{ route('terms.index') }}"
                   class="hover:underline font-bold hover:text-gray-800 dark:hover:text-gray-200">
                    Termos de Uso
                </a>
                e
                <a target="_blank"
                   href="{{ route('policy.index') }}"
                   class="hover:underline font-bold hover:text-gray-800 dark:hover:text-gray-200">
                    Política de Privacidade<span class="font-normal">.</span>
                </a>
            </div>
        </div>

        {{--
        <div class="px-2">
            <p class="flex flex-wrap justify-center gap-1 text-sm text-gray-500">
                <span class="font-semibold text-gray-600 dark:text-gray-400">Não tem uma conta?</span>
                <span>Contate o coordenador do seu curso</span>
            </p>
        </div>
        --}}
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
