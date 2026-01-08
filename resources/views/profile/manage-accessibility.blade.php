<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-section-title>
        <x-slot name="title">Acessibilidade</x-slot>
        <x-slot name="description">
            Ferramentas e recursos voltados à inclusão e melhoria da experiência de uso para todos os perfis de usuários.
        </x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="flex flex-col gap-4">
            @if(config('accessibility.daltonism'))
                <!-- Container do filtro -->
                <div
                    x-data="{ daltonism_enabled:true }"
                    x-init="
                        daltonism_enabled = localStorage.getItem('daltonism_enabled') === 'true'
                    "
                    class="flex flex-col flex-1 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6 sm:rounded-lg border border-gray-200 dark:border-gray-950 shadow-md z-10 transition duration-150 ease-in-out"
                >
                    <div class="inline-flex items-center gap-2 mb-4">
                        <div class="flex items-center justify-center bg-gradient-to-tr from-blue-600 to-blue-500 rounded-lg p-2 w-10 h-10">
                            {{-- Ícone Eye do Lucide --}}
                            <x-lucide-eye class="w-[18px] h-[18px] text-white dark:text-gray-300 shrink-0 transition duration-150 ease-in-out" />
                        </div>

                        <label for="type-daltonism" class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-[0.5px] transition duration-150 ease-in-out">Filtros de daltonismo</label>
                    </div>

                    <div class="max-w-xl mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out">
                            O daltonismo é uma condição visual que altera a forma como as cores são percebidas.
                            Para tornar a navegação mais confortável, oferecemos filtros de simulação que ajudam a ajustar
                            a visualização conforme cada tipo de daltonismo.
                            <a
                                rel="noreferrer noopener"
                                href="/manual?#accessibility"
                                class="text-secondary-blue dark:text-blue-400 font-medium hover:underline
                                    transition ease-in-out duration-150"
                            >Ler mais.</a>
                        </p>
                    </div>

                    <x-select id="daltonism-select" data-daltonism-select class="mt-auto w-full !h-[40px]">
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

                    <hr class="my-2"/>

                    <div class="flex flex-wrap items-center gap-2">
                        <x-button
                            id="showDaltonismIcon"
                            type="button"
                            x-on:click="
                                $el.blur();
                                daltonism_enabled = !daltonism_enabled;
                                localStorage.setItem('daltonism_enabled',daltonism_enabled);
                                $dispatch('toggle-daltonism');
                            "
                            x-bind:class="{
                                'whitespace-nowrap': true,
                                '!bg-gray-300 !text-gray-700': !daltonism_enabled
                            }"
                            x-text="daltonism_enabled ? 'Ocultar Ícone' : 'Exibir ícone'"
                        >
                        </x-button>
                        <span id="showDaltonismText" class="text-xs text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out"
                            x-text="daltonism_enabled ? 'Ícone visível em todas as páginas' : 'Ícone não visível'"
                        >
                        </span>
                    </div>
                </div>
            @endif
            @if(config('accessibility.libras'))
                <div
                    x-data="{ vlibras_enabled: true }"
                    x-init="
                        vlibras_enabled = localStorage.getItem('vlibras_enabled') === 'true';
                    "
                    class="flex-1 bg-white dark:bg-gray-900 px-4 py-5 sm:p-6 sm:rounded-lg border border-gray-200 dark:border-gray-950 shadow-md z-10 transition duration-150 ease-in-out"
                >
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center justify-center bg-gradient-to-tr from-blue-600 to-blue-500 rounded-lg p-2 w-10 h-10">
                            {{-- Ícone hand do Lucide --}}
                            <x-lucide-hand class="w-[18px] h-[18px] text-white dark:text-gray-300 shrink-0 transition duration-150 ease-in-out" />
                        </div>

                        <label for="type-daltonism" class="text-sm font-bold text-gray-700 dark:text-gray-300 uppercase tracking-[0.5px] transition duration-150 ease-in-out">Assistente de libras</label>
                    </div>

                    <div class="max-w-xl mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out">
                            Libras (Língua Brasileira de Sinais) é a língua natural da comunidade surda.
                            Nosso sistema disponibiliza o VLibras, que traduz textos, elementos da interface
                            e partes do conteúdo multimídia para Libras por meio de um avatar animado.
                            <a
                                rel="noreferrer noopener"
                                href="/manual?#accessibility"
                                class="text-secondary-blue dark:text-blue-400 font-medium hover:underline
                                transition duration-150 ease-in-out"
                            >Ler mais.</a>
                        </p>
                    </div>

                    <div class="flex flex-wrap items-center gap-2">
                        <x-button
                            id="showVlibrasIcon"
                            type="button"
                            x-on:click="
                                $el.blur();
                                vlibras_enabled = !vlibras_enabled;
                                localStorage.setItem('vlibras_enabled', vlibras_enabled);
                                $dispatch('toggle-vlibras');
                            "
                            x-bind:class="{
                                'whitespace-nowrap': true,
                                '!bg-gray-300 !text-gray-700': !vlibras_enabled
                            }"
                            x-text="vlibras_enabled ? 'Ocultar ícone' : 'Exibir ícone'"
                        >
                        </x-button>
                        <span id="showVlibrasText" class="text-xs text-gray-600 dark:text-gray-300 transition duration-150 ease-in-out"
                              x-text="vlibras_enabled ? 'Ícone visível em todas as páginas' : 'Ícone não visível'"
                        >
                        </span>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <script>
        {{-- Placeholder para a sessão de daltonismo antes do alpine carregar --}}
        const showDaltonismIcon = document.getElementById('showDaltonismIcon');
        const daltonism_enabled = localStorage.getItem('daltonism_enabled') === 'true';
        const showDaltonismText = document.getElementById('showDaltonismText');

        showDaltonismIcon.textContent = daltonism_enabled ? 'Ocultar Ícone' : 'Exibir ícone';
        showDaltonismText.textContent = daltonism_enabled ? 'Ícone visível em todas as páginas' : 'Ícone não visível';
        if (!daltonism_enabled) {
            showDaltonismIcon.className += ' !bg-gray-300 !text-gray-700';
        }

        {{-- Placeholder para a sessão de daltonismo antes do alpine carregar --}}
        const showVlibrasIcon = document.getElementById('showVlibrasIcon');
        const vlibras_enabled = localStorage.getItem('vlibras_enabled') === 'true';
        const showVlibrasText = document.getElementById('showVlibrasText');

        showVlibrasIcon.textContent = vlibras_enabled ? 'Ocultar ícone' : 'Exibir ícone';
        showVlibrasText.textContent = vlibras_enabled ? 'Ícone visível em todas as páginas' : 'Ícone não visível';
        if (!vlibras_enabled) {
            showVlibrasIcon.className += ' !bg-gray-300 !text-gray-700';
        }
    </script>
</div>
