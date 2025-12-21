<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{config('app.name') . ($title ?? '' ? ' - ' .$title : '')}}</title>
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

        <main id="app" class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </main>

        @livewireScripts
        @stack('scripts')
        @if(config('accessibility.libras'))
            <!-- Assistente de libras -->
            <div x-data="{ vlActive: localStorage.getItem('vlibras_enabled') === 'true' }"
                 class="flex">

                <div vw class="enabled" x-show="vlActive" x-cloak>
                    <div vw-access-button class="active"></div>
                    <div vw-plugin-wrapper>
                        <div class="vw-plugin-top-wrapper"></div>
                    </div>
                </div>
                <script src="https://vlibras.gov.br/app/vlibras-plugin.js"></script>
                <script>
                    (() => {
                        if (!localStorage.getItem('vlibras_enabled')) {
                            localStorage.setItem('vlibras_enabled', 'true');
                        }
                    })();
                    document.addEventListener("DOMContentLoaded", () => {
                        new window.VLibras.Widget('https://vlibras.gov.br/app');
                    });
                </script>
            </div>
        @endif
    </body>
</html>
