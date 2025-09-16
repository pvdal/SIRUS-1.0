<div>
    {{-- Nome do Critério --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Critério"/>
        <x-input id="name" type="text" autocomplete="off" class="w-full"
                 placeholder="Ex: Ortografia e Gramática" x-model="name"
                 @keydown.enter.prevent="saveCriterion()"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>

    {{-- Descrição do Critério --}}
    <div class="mt-4">
        <x-label for="description" value="Descrição (opcional)"/>
        {{-- Usamos <textarea> para descrições que podem ser mais longas --}}
        <textarea id="description" autocomplete="off" class="w-full rounded border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm"
                  placeholder="Detalhes sobre o que este critério avalia..." x-model="description"
                  rows="4"></textarea>
        <template x-if="errors.description">
            <p class="text-red-600 text-sm" x-text="errors.description[0]"></p>
        </template>
    </div>

    <template x-if="edit && (created_at || updated_at)">
        <div class="mt-5">
            <p class="text-sm text-gray-800" x-text="created_at"></p>
            <p class="text-sm text-gray-800" x-text="updated_at"></p>
        </div>
    </template>
</div>
