<!-- Container do filtro -->
<div
    x-cloak
    x-data="{
        showDaltonismIcon: true,
        open: false,
        showFilters: false,
        showPositionMenu: false,
        position: 'middle-right',

        vlibrasEnabled: false,

        init() {
            if (!localStorage.getItem('daltonism_enabled')) {
                localStorage.setItem('daltonism_enabled', 'true');
            } else {
                this.showDaltonismIcon = localStorage.getItem('daltonism_enabled') === 'true';
            }
            this.vlibrasEnabled = localStorage.getItem('vlibras_enabled') === 'true';
        },

        // Posições do botão
        positionsButton: {
            'top-left':     'top-[74px] left-[10px]',
            'top-right':    'top-[74px] right-[10px]',

            'middle-left':  'top-1/2 translate-y-[80%] left-[10px]',
            'middle-right': 'top-1/2 translate-y-[80%] right-[10px]',

            'bottom-left':  'bottom-[10px] left-[10px]',
            'bottom-right': 'bottom-[10px] right-[10px]',
        },

        // Posições do menu
        positionsMenu: {
            'top-left':     'left-0 top-full mt-2',
            'top-right':    'right-0 top-full mt-2',

            'middle-left':  'left-0 top-full mt-2',
            'middle-right': 'right-0 top-full mt-2',

            'bottom-left':  'left-0 bottom-full mb-2',
            'bottom-right': 'right-0 bottom-full mb-2',
        },

        // Posições do menu
        positionsNav: {
            'top-left':     'left-[3.1rem]',
            'top-right':    'right-[3.1rem]',

            'middle-left':  'left-[3.1rem]',
            'middle-right': 'right-[3.1rem]',

            'bottom-left':  'left-[3.1rem]',
            'bottom-right': 'right-[3.1rem]',
        },
    }"
    x-init="init()"
    x-on:toggle-daltonism.window="showDaltonismIcon = !showDaltonismIcon"
    x-on:toggle-vlibras.window="vlibrasEnabled = !vlibrasEnabled"
>
    @php
        $icons = [
            'top-left'     => 'lucide-arrow-up-left',
            'top-right'    => 'lucide-arrow-up-right',
            'middle-left'  => 'lucide-arrow-left',
            'middle-right' => 'lucide-arrow-right',
            'bottom-left'  => 'lucide-arrow-down-left',
            'bottom-right' => 'lucide-arrow-down-right',
        ];
    @endphp
    <div
        x-show="showDaltonismIcon"
        class="fixed"
        style="z-index: 60;"
        :class="[
            positionsButton[position],
            vlibrasEnabled && position.startsWith('bottom-') ? ' -translate-y-[140%]' : ''
        ]"
        @click.away="open = false"
    >
        <!-- BOTÃO -->
        <button
            class="relative bg-gradient-to-tr from-blue-600 to-blue-500 rounded-lg p-2 w-10 h-10"
            @click="open = !open"
        >
            <x-lucide-eye class="w-[24px] h-[24px] text-white shrink-0" />
        </button>
        <!-- Menu de navegação -->
        <nav
            x-show="open"
            class="absolute flex items-center gap-1 top-0 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-900 shadow rounded-lg p-1 h-10"
            :class="positionsNav[position]"
        >
            <!-- Filtros -->
            <button
                @click="showFilters = !showFilters"
                class="flex-none w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 dark:hover:bg-gray-700"
            >
                <x-lucide-stretch-horizontal class="w-4 h-4 text-gray-700 dark:text-gray-100" />
            </button>

            <!-- Posicionamento -->
            <button
                @click="showPositionMenu = !showPositionMenu"
                class="flex-none w-8 h-8 flex items-center justify-center rounded hover:bg-gray-100 dark:hover:bg-gray-700"
            >
                <x-lucide-move class="w-4 h-4 text-gray-700 dark:text-gray-100" />
            </button>
        </nav>

        <!-- Menu de posições -->
        <div
            x-show="showPositionMenu"
            @click.away="showPositionMenu = false"
            class="absolute w-32 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-900 shadow-xl rounded-lg  p-3"
            :class="positionsMenu[position]"
        >
            <h4 class="text-sm font-semibold text-gray-700 dark:text-gray-100 mb-2">Posição na tela</h4>

            <div class="grid grid-cols-2 gap-2 text-sm">
                @foreach ($icons as $key => $component)
                    <button
                        @click="position = '{{ $key }}'"
                        class="flex justify-center items-center px-2 py-1 rounded border text-gray-700 dark:text-gray-100 hover:bg-opacity-90 transition"
                        :class="{ 'bg-blue-600 text-white border-blue-600': position === '{{ $key }}' }"
                    >
                        <x-dynamic-component :component="$component" class="w-4 h-4 shrink-0" />
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Seleção de filtro -->
        <div
            x-show="showFilters"
            class="absolute z-20 bg-white dark:bg-gray-800 min-w-[220px] rounded-lg border border-gray-200 dark:border-gray-900 shadow-md px-4 py-[14px]"
            @click.away="showFilters = false"
            :class="positionsMenu[position]"
        >
            <div class="flex items-center gap-2 mb-2.5">
                <!-- Ícone Eye -->
                <x-lucide-eye class="w-[18px] h-[18px] md:w-[20px] md:h-[20px] text-gray-600 dark:text-gray-100 shrink-0" />
                <label for="type-daltonism" class="text-[10px] md:text-xs font-medium text-gray-600 dark:text-gray-100 uppercase tracking-[0.5px]">Filtros de daltonismo</label>
            </div>

            <x-select id="type-daltonism" data-daltonism-select class="w-full text-sm xlg:text-base">
                <option value="normal">Padrão</option>
                <option value="achromatomaly">Acromatomalia</option>
                <option value="achromatopsia">Acromatopsia</option>
                <option value="deuteranomaly">Deuteranomalia</option>
                <option value="deuteranopia">Deuteranopia</option>
                <option value="protanomaly">Protanomalia</option>
                <option value="protanopia">Protanopia</option>
                <option value="tritanomaly">Tritanomalia</option>
                <option value="tritanopia">Tritanopia</option>
            </x-select>
        </div>
    </div>
</div>
