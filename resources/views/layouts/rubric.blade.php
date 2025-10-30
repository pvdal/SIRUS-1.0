@php
    $tabId = session('tabId');
    $dynamicTokens = session('dynamic_tokens', []);
    $dynamicToken = $dynamicTokens[$tabId][0] ?? null;
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="request-prefix" content="{{ config('secure.request_prefix') }}">
    <meta name="tabId" content="{{ $tabId }}">
    <meta name="dynamic-token" content="{{ $dynamicToken }}">

    <title>{{config('app.name') . ($title ?? '' ? ' | ' .$title : '')}}</title>
    <link rel="icon" type="image/icon" href="{{ asset('favicon.ico') }}?v=1">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Styles -->
    @livewireStyles

    @if(config('appearance.switch_theme'))
        <script>
            {{-- Inicializa o tema --}}
            (() => {
                const savedTheme = localStorage.getItem('theme');
                const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            })();
        </script>
    @endif
    {{-- Disponibiliza a url do sistema setada no .env, o js vai usar ela pra montar a url do paper --}}
    <script>
        window.appUrl = "{{ config('app.url') }}";
    </script>
</head>
<body class="font-sans antialiased"
      @if(config('appearance.switch_theme'))
          x-data="themeHandler()"
      x-bind:class="theme"
      x-init="init()"
    @endif
>
    {{-- Feedback messages: success, fail...--}}
    <x-banner />
    {{-- Impede que o usuário tenha acesso ao sistema caso não aceite os termos de uso e políticas de privacidade juntamente com o middleware 'terms-accepted' --}}
    @if(config('secure.terms_accept'))
        @livewire('legal.terms-accept')
    @endif

    <div class="min-h-screen bg-gray-100 dark:bg-gray-700 transition duration-150 ease-in-out">


        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow dark:bg-gray-900 transition duration-150 ease-in-out">
                <div class="flex items-center justify-between max-w-[2100px] mx-auto px-4 py-6 sm:px-6 lg:px-8 text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out">

                    <div class="flex items-center space-x-4">
                        {{ $header }}
                    </div>

                    <div class="flex items-center space-x-4">

                        @if(config('appearance.switch_theme'))
                            <button
                                @click="toggleTheme()"
                                class="p-2 rounded-lg border bg-gray-200 dark:bg-gray-800 dark:border-gray-600 dark:text-gray-200 transition duration-150 ease-in-out hover:bg-gray-300 dark:hover:bg-gray-700"
                                title="Alternar tema"
                            >
                                <!-- Ícone modo claro -->
                                <x-lucide-moon class="h-4 w-4 block dark:hidden transition duration-150 ease-in-out"/>
                                <!-- Ícone modo escuro -->
                                <x-lucide-sun class="h-4 w-4 hidden dark:block transition duration-150 ease-in-out"/>
                            </button>
                        @endif


                    </div>
                </div>
            </header>

        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @livewireScripts
    @stack('scripts')
</body>
</html>
