<div class="relative flex flex-col border-t border-gray-100 dark:border-gray-700 lg:max-h-[calc(100vh-8.5rem)] overflow-hidden">
    <div class="flex flex-wrap justify-between items-center gap-2 shadow-sm dark:shadow-md p-5 pt-4">
        <h3 class="text-gray-800 dark:text-gray-200 font-bold text-base">Preferências de leitura</h3>
        <button
            class="text-gray-700 dark:text-gray-400 text-sm
            hover:bg-gray-200 dark:hover:bg-gray-800
            border border-gray-200 dark:border-gray-700
            flex items-center gap-1 rounded-md px-3 py-1"
            title="Restaurar configurações padrão"
            x-on:click="
                stickyNav = false;
                showChapterNav = true;

                fontSize = 1;
                leadingHeight = 2;
                letterSpacing = 1;
                wordSpacing = 1;
            "
        >
            <x-lucide-refresh-ccw class="w-4 h-4 shrink-0"/>
            <span>Restaurar</span>
        </button>
    </div>
    <nav class="flex-1 min-h-0 overflow-y-auto p-2 space-y-5 scrollbar-custom">
        <div class="hidden xl:block bg-gray-100 dark:bg-gray-800 p-4 rounded-lg space-y-4">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <h4 class="font-semibold text-gray-900 dark:text-white">Navegação do capítulo</h4>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Mantenha o controle de navegação interna sempre visível</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" x-model="stickyNav">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>
            <hr class="border-gray-300 dark:border-gray-700">
            <div class="flex items-center justify-between gap-2">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Exibir controle de navegação</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" value="" class="sr-only peer" x-model="showChapterNav">
                    <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                </label>
            </div>
        </div>
        <div class="block bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <div class="space-y-1">
                <h4 class="font-semibold text-gray-900 dark:text-white">
                    Tamanho da fonte
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Ajuste o conforto da leitura do conteúdo
                </p>
                <div class="flex flex-col">
                    <div class="mt-3 grid grid-cols-3 self-start rounded-lg bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-400">
                        <button
                            x-on:click="fontSize = 1"
                            :class="fontSize === 1 ? 'bg-blue-600 text-gray-100' : 'bg-transparent hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-slate-600'"
                            class="px-3 py-1.5 text-sm font-medium rounded-s-lg">
                            A
                        </button>
                        <button
                            x-on:click="fontSize = 2"
                            :class="fontSize === 2 ? 'bg-blue-600 text-gray-100' : 'bg-transparent hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-slate-600'"
                            class="px-3 py-1.5 text-sm font-medium">
                            A+
                        </button>
                        <button
                            x-on:click="fontSize = 3"
                            :class="fontSize === 3 ? 'bg-blue-600 text-gray-100' : 'bg-transparent hover:text-gray-900 dark:hover:text-gray-100 hover:bg-gray-100 dark:hover:bg-slate-600'"
                            class="px-3 py-1.5 text-sm font-medium rounded-e-lg">
                            A++
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="block bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <div class="space-y-1">
                <h4 class="font-semibold text-gray-900 dark:text-white">
                    Espaçamento entre linhas
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Ajuste a densidade do texto
                </p>

                <div class="mt-3 space-y-1">
                    <input
                        type="range"
                        min="1"
                        max="4"
                        step="1"
                        class="w-full range-custom"
                        x-model.number="leadingHeight"
                    >

                    <div class="flex justify-between px-[0.3rem] text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>1</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>2</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>3</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>4</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <div class="space-y-1">
                <h4 class="font-semibold text-gray-900 dark:text-white">
                    Espaçamento entre Letras
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Melhora a legibilidade de cada palavra
                </p>

                <div class="mt-3 space-y-1">
                    <input
                        type="range"
                        min="1"
                        max="4"
                        step="1"
                        class="w-full range-custom"
                        x-model.number="letterSpacing"
                    >

                    <div class="flex justify-between px-[0.3rem] text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>1</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>2</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>3</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>4</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="block bg-gray-100 dark:bg-gray-800 p-4 rounded-lg">
            <div class="space-y-1">
                <h4 class="font-semibold text-gray-900 dark:text-white">
                    Espaçamento entre palavras
                </h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Facilita a separação visual entre termos
                </p>

                <div class="mt-3 space-y-1">
                    <input
                        type="range"
                        min="1"
                        max="4"
                        step="1"
                        class="w-full range-custom"
                        x-model.number="wordSpacing"
                    >

                    <div class="flex justify-between px-[0.3rem] text-xs text-gray-500 dark:text-gray-400">
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>1</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>2</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>3</span>
                        </div>
                        <div class="flex flex-col items-center">
                            <span class="bg-gray-500 h-1 w-px mb-1"></span>
                            <span>4</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
