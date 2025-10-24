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
            <!-- Filtros SVG -->
            <svg style="position: absolute; width: 0; height: 0;" aria-hidden="true">
                <defs>
                    <!-- Acromatomalia: forma parcial de acromatopsia (sensibilidade reduzida às cores). -->
                    <filter id="achromatomaly" color-interpolation-filters="linearRGB">
                        <feColorMatrix type="matrix" values="
                            0.6 0.4 0.0 0 0
                            0.3 0.7 0.0 0 0
                            0.2 0.3 0.5 0 0
                            0.0 0.0 0.0 1 0"/>
                    </filter>

                    <!-- Achromatopsia: ausência total de percepção de cor. -->
                    <filter id="achromatopsia" color-interpolation-filters="linearRGB">
                        <feColorMatrix type="matrix" values="
                            0.299 0.587 0.114 0 0
                            0.299 0.587 0.114 0 0
                            0.299 0.587 0.114 0 0
                            0.000 0.000 0.000 1 0"/>
                    </filter>

                    <!-- Deuteranopia: Deficiência de verde (cone M) - Viénot 1999 -->
                    <filter id="deuteranopia" color-interpolation-filters="linearRGB">
                        <feColorMatrix type="matrix" values="
                            0.367322  0.632678  0.000000  0  0
                            0.280085  0.719915  0.000000  0  0
                           -0.011820  0.042940  0.968881  0  0
                            0.000000  0.000000  0.000000  1  0"/>
                    </filter>

                    <!-- Protanopia: Deficiência de vermelho (cone L) - Viénot 1999 -->
                    <filter id="protanopia" color-interpolation-filters="linearRGB">
                        <feColorMatrix type="matrix" values="
                            0.152286  0.847714  0.000000  0  0
                            0.114503  0.885497  0.000000  0  0
                           -0.003882 -0.007600  1.011482  0  0
                            0.000000  0.000000  0.000000  1  0"/>
                    </filter>

                    <!-- Tritanopia: Deficiência de azul (cone S) - Viénot 1999 -->
                    <filter id="tritanopia" color-interpolation-filters="linearRGB">
                        <feColorMatrix type="matrix" values="
                            1.255528 -0.255528  0.000000  0  0
                           -0.076749  1.076749  0.000000  0  0
                            0.030908  0.691367  0.277725  0  0
                            0.000000  0.000000  0.000000  1  0"/>
                    </filter>
                </defs>
            </svg>

            <!-- Container do filtro -->
            <div  class="fixed bottom-2 left-2 bg-white px-4 py-[14px] rounded-lg border border-gray-200 shadow-md min-w-[215px] z-10">
                <div class="flex items-center gap-2 mb-2.5">
                    <!-- Ícone Eye do Lucide -->
                    <x-lucide-eye class="w-[18px] h-[18px] text-gray-600 shrink-0" />
                    <label for="type-daltonism" class="text-[12px] font-medium text-gray-600 uppercase tracking-[0.5px]">Filtros de daltonismo</label>
                </div>

                <x-select id="type-daltonism" class="w-full">
                    <option value="normal">Normal</option>
                    <option value="achromatomaly">Acromatomalia</option>
                    <option value="achromatopsia">Acromatopsia</option>
                    <option value="deuteranopia">Deuteranopia</option>
                    <option value="protanopia">Protanopia</option>
                    <option value="tritanopia">Tritanopia</option>
                </x-select>
            </div>
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
                    deuteranopia: 'url(#deuteranopia)',
                    protanopia: 'url(#protanopia)',
                    tritanopia: 'url(#tritanopia)',
                };

                // 🔹 Recupera o filtro salvo (ou "normal" por padrão)
                const savedFilter = localStorage.getItem('daltonismFilter') || 'normal';

                // 🔹 Aplica o filtro salvo imediatamente
                app.style.filter = filters[savedFilter] || 'none';
                select.value = savedFilter;

                // 🔹 Quando o usuário muda o filtro
                select.addEventListener('change', () => {
                    const selected = select.value;
                    app.style.filter = filters[selected] || 'none';
                    localStorage.setItem('daltonismFilter', selected);
                });
            </script>
        @endif
    </body>
</html>
