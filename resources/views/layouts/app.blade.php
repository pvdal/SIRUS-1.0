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

        @if(config('accessibility.daltonism'))
            {{-- script dos filtros de daltonismo --}}
            <script>
                (() => {
                    if (!localStorage.getItem('daltonism_enabled')) {
                        localStorage.setItem('daltonism_enabled', 'true');
                    }

                    const filters = {
                        normal: 'none',
                        achromatomaly: 'url(#achromatomaly)',
                        achromatopsia: 'url(#achromatopsia)',
                        deuteranomaly: 'url(#deuteranomaly)',
                        deuteranopia: 'url(#deuteranopia)',
                        protanomaly: 'url(#protanomaly)',
                        protanopia: 'url(#protanopia)',
                        tritanomaly: 'url(#tritanomaly)',
                        tritanopia: 'url(#tritanopia)',
                    };

                    const applyFilterToApp = (filter) => {
                        const el = document.getElementById('app');
                        if (!el) return requestAnimationFrame(() => applyFilterToApp(filter));
                        el.style.filter = filters[filter] || 'none';
                    };

                    {{-- 1. Aplicar filtro salvo imediatamente --}}
                    const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';
                    applyFilterToApp(savedFilter);

                    {{-- 2. Sincroniza todos os selects de daltonismo --}}
                    const syncSelects = (filter) => {
                        document.querySelectorAll('[data-daltonism-select]').forEach(sel => {
                            sel.value = filter;
                        });
                    };

                    {{-- 3. Aguarda load para associar listeners em TODOS os selects --}}
                    window.addEventListener('load', () => {
                        const selects = document.querySelectorAll('[data-daltonism-select]');
                        if (!selects.length) return;

                        {{-- aplica valor inicial a todos --}}
                        syncSelects(savedFilter);

                        selects.forEach(select => {
                            select.addEventListener('change', () => {
                                const selected = select.value;

                                {{-- aplica no app --}}
                                applyFilterToApp(selected);

                                {{-- salva --}}
                                localStorage.setItem('daltonismFilter', selected);

                                {{-- sincroniza os outros selects --}}
                                syncSelects(selected);
                            });
                        });
                    });
                })();
            </script>
        @endif

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
        {{-- Disponibiliza a url do sistema setada no .env, o js vai usar ela pra montar a url do paper. Também inicia valores no localStorage--}}
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
        @if(config('accessibility.daltonism'))
            <x-accessibility.daltonism-filters/>
            <x-accessibility.daltonism-select/>
        @endif
        {{-- Feedback messages: success, fail...--}}
        <x-banner />
        {{-- Impede que o usuário tenha acesso ao sistema caso não aceite os termos de uso e políticas de privacidade juntamente com o middleware 'terms-accepted' --}}
        @if(config('secure.terms_accept'))
            @livewire('legal.terms-accept')
        @endif

        <div id="app" class="min-h-screen bg-gray-100 dark:bg-gray-700 transition duration-150 ease-in-out">
            <!-- Navigation menu -->
            @if(!request()->routeIs('evaluations.store', 'evaluations.index'))
                @livewire('navigation-menu')
            @endif

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow dark:bg-gray-900 transition duration-150 ease-in-out">
                    <div class="flex flex-row max-w-[2100px] mx-auto px-4 py-6 sm:px-6 lg:px-8 justify-between items-center text-gray-800 dark:text-gray-100 transition duration-150 ease-in-out">
                        {{ $header }}
                        @if(config('appearance.switch_theme'))
                            <button
                                @click="toggleTheme()"
                                class="ms-auto sm:mx-0 relative flex items-center gap-2 p-2 rounded-lg
                                border border-gray-300 dark:border-gray-600
                                text-gray-500 dark:text-gray-300
                                hover:bg-gray-100 dark:hover:bg-gray-800
                                transition duration-150 ease-in-out"
                                aria-label="Alternar tema"
                            >
                                <!-- Slot fixo do ícone -->
                                <span class="relative w-4 h-4">
                                    <!-- Moon -->
                                    <x-lucide-moon
                                        class="absolute inset-0 h-4 w-4
                                               transition-all duration-300 ease-in-out
                                               opacity-100 scale-100 rotate-0
                                               dark:opacity-0 dark:scale-75 dark:-rotate-90"
                                    />
                                        <!-- Sun -->
                                    <x-lucide-sun
                                        class="absolute inset-0 h-4 w-4
                                               transition-all duration-300 ease-in-out
                                               opacity-0 scale-75 rotate-90
                                               dark:opacity-100 dark:scale-100 dark:rotate-0"
                                    />
                                </span>
                            </button>
                        @endif
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
        @if(config('accessibility.libras'))
            <div x-data="{ vlActive: localStorage.getItem('vlibras_enabled') === 'true' }"
                 x-on:toggle-vlibras.window="vlActive = !vlActive"
                 class="flex">

                <div vw class="enabled" x-show="vlActive" x-cloak>
                    <div vw-access-button class="active"></div>
                    <div vw-plugin-wrapper>
                        <div class="vw-plugin-top-wrapper"></div>
                    </div>
                </div>

                <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
                <script>
                    document.addEventListener("DOMContentLoaded", () => {
                        new window.VLibras.Widget('https://vlibras.gov.br/app');
                    });
                </script>
            </div>
        @endif
    </body>
</html>
