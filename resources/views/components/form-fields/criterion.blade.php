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
    {{-- Descrição de Excelente --}}
    <div class="mt-4">
        <x-label for="excellent" value="Descrição de excelente"/>
        <textarea id="excellent" x-model="excellent" class="w-full rounded border-gray-300"
                  placeholder="Detalhes sobre excelente..." rows="2"></textarea>
    </div>

    {{-- Descrição de Bom --}}
    <div class="mt-4">
        <x-label for="good" value="Descrição de bom"/>
        <textarea id="good" x-model="good" class="w-full rounded border-gray-300"
                  placeholder="Detalhes sobre bom..." rows="2"></textarea>
    </div>

    {{-- Descrição de satisfactory --}}
    <div class="mt-4">
        <x-label for="satisfactory" value="Descrição de satisfatório"/>
        <textarea id="satisfactory" x-model="satisfactory" class="w-full rounded border-gray-300"
                  placeholder="Detalhes sobre satisfatório..." rows="2"></textarea>
    </div>

    {{-- Descrição de Insatisfatório --}}
    <div class="mt-4">
        <x-label for="unsatisfactory" value="Descrição de insatisfatório"/>
        <textarea id="unsatisfactory" x-model="unsatisfactory" class="w-full rounded border-gray-300"
                  placeholder="Detalhes sobre insatisfatório..." rows="2"></textarea>
    </div>

</div>
