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

                    // Obtém filtro salvo imediatamente
                    const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';

                    // Se o app ainda não existir, tenta aplicar assim que ele for encontrado
                    const applyFilter = () => {
                        const el = document.getElementById('app');
                        if (!el) return requestAnimationFrame(applyFilter);
                        el.style.filter = filters[savedFilter] || 'none';
                    };

                    applyFilter();

                    // Se o select existir mais tarde, adiciona o listener
                    window.addEventListener('load', () => {
                        const select = document.getElementById('type-daltonism');
                        if (!select) return;
                        select.value = savedFilter;
                        select.addEventListener('change', () => {
                            const selected = select.value;
                            document.getElementById('app').style.filter = filters[selected] || 'none';
                            localStorage.setItem('daltonismFilter', selected);
                        });
                    });
                })();
            </script>
        @endif
    </head>
    <body>
        @if(config('accessibility.daltonism'))
            <x-accessibility.daltonism-filters/>
            <x-accessibility.daltonism-select/>
        @endif
        <div id="app" class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

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
                    document.addEventListener("DOMContentLoaded", () => {
                        new window.VLibras.Widget('https://vlibras.gov.br/app');
                    });
                </script>
            </div>
        @endif
    </body>
</html>
