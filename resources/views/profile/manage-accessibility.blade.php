<div class="md:grid md:grid-cols-3 md:gap-6">
    <x-section-title>
        <x-slot name="title">Acessibilidade</x-slot>
        <x-slot name="description">Ferramentas de acessibilidade</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <div class="flex items-center justify-end gap-4">
            @if(config('accessibility.daltonism'))
                <!-- Container do filtro -->
                <div  class="bg-white px-4 py-[14px] rounded-lg border border-gray-200 shadow-md min-w-[216px] z-10">
                    <div class="flex items-center gap-2 mb-2.5">
                        <!-- Ícone Eye do Lucide -->
                        <x-lucide-eye class="w-[18px] h-[18px] text-gray-600 shrink-0" />
                        <label for="type-daltonism" class="text-[12px] font-medium text-gray-600 uppercase tracking-[0.5px]">Filtros de daltonismo</label>
                    </div>

                    <x-select id="type-daltonism" class="w-full !min-h-[40px] !h-[40px]">
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
            @endif
            @if(config('accessibility.libras'))
                <div id="toggleVlibras" class="flex flex-col justify-center bg-white px-4 py-[14px] rounded-lg border border-gray-200 shadow-md min-w-[216px] z-10">
                    <div class="flex items-center gap-2 mb-2.5">
                        <!-- Ícone Eye do Lucide -->
                        <x-lucide-hand class="w-[18px] h-[18px] text-gray-600 shrink-0" />
                        <label for="type-daltonism" class="text-[12px] font-medium text-gray-600 uppercase tracking-[0.5px]">Assistente de libras</label>
                    </div>
                    <x-secondary-button
                        type="button"
                        x-on:click="
                                        $el.blur();
                                        vlActive = !vlActive;
                                        localStorage.setItem('vlibras_enabled', vlActive);
                                        $dispatch('toggle-vlibras');
                                    "
                        class="space-x-2 !text-[0.785rem] min-h-[42px]"
                    >
                        <span id="btnTextLibras"></span>
                    </x-secondary-button>
                </div>
                <script>
                    const btnText = document.getElementById('btnTextLibras');
                    btnText.textContent = localStorage.getItem('vlibras_enabled') === 'true'
                        ? 'Desativar Libras'
                        : 'Ativar Libras';
                </script>
                <div x-data="{ vlActive: true }"
                     x-init="
                                        vlActive = localStorage.getItem('vlibras_enabled') === 'true';
                                        document.getElementById('toggleVlibras')?.remove();
                                    "
                     class="flex"
                     x-cloak>
                    <!-- Botão para ativar/desativar -->
                    <div  class="flex flex-col justify-center bg-white px-4 py-[14px] rounded-lg border border-gray-200 shadow-md min-w-[216px] z-10">
                        <div class="flex items-center gap-2 mb-2.5">
                            <!-- Ícone Eye do Lucide -->
                            <x-lucide-hand class="w-[18px] h-[18px] text-gray-600 shrink-0" />
                            <label for="type-daltonism" class="text-[12px] font-medium text-gray-600 uppercase tracking-[0.5px]">Assistente de libras</label>
                        </div>
                        <x-secondary-button
                            type="button"
                            x-on:click="
                                            $el.blur();
                                            vlActive = !vlActive;
                                            localStorage.setItem('vlibras_enabled', vlActive);
                                            $dispatch('toggle-vlibras');
                                        "
                            class="space-x-2 !text-[0.785rem] min-h-[42px]"
                        >
                            <span x-text="vlActive ? 'Desativar Libras' : 'Ativar Libras'"></span>
                        </x-secondary-button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
