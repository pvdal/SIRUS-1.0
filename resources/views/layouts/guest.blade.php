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
    </head>
    <body>
        @if(config('accessibility.daltonism'))
            <x-accessibility.daltonism-filters/>
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
        @if(config('accessibility.daltonism'))
            {{-- script dos filtros de daltonismo --}}
            <script>
                const app = document.getElementById('app');
                const select = document.getElementById('type-daltonism');

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

                // Recupera o filtro salvo (ou "normal" por padrão)
                const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';

                // Aplica o filtro salvo imediatamente
                app.style.filter = filters[savedFilter] || 'none';
                select.value = savedFilter;

                // Quando o usuário muda o filtro
                select.addEventListener('change', () => {
                    const selected = select.value;
                    app.style.filter = filters[selected] || 'none';
                    localStorage.setItem('daltonismFilter', selected);
                });
            </script>
        @endif
    </body>
</html>
