<!-- Container do filtro -->
<div  class="fixed bottom-2 left-2 bg-white px-4 py-[14px] rounded-lg border border-gray-200 shadow-md min-w-[215px] z-10">
    <div class="flex items-center gap-2 mb-2.5">
        <!-- Ícone Eye do Lucide -->
        <x-lucide-eye class="w-[18px] h-[18px] text-gray-600 shrink-0" />
        <label for="type-daltonism" class="text-[12px] font-medium text-gray-600 uppercase tracking-[0.5px]">Filtros de daltonismo</label>
    </div>

    <x-select id="type-daltonism" class="w-full">
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
