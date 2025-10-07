<div>
    {{-- Nome do Eixo --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Eixo"/>
        <x-input id="name" type="text" autocomplete="off" class="w-full"
                 placeholder="Ex: Formatação e Apresentação"
                 x-model="name"
                 @keydown.enter.prevent="saveAxes()"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>

    {{-- Buscar Critérios --}}
    <div class="mt-4">
        <x-label value="Buscar Critérios" />
        <x-input type="text"
                 x-model="searchCriterion"
                 placeholder="Digite o nome do critério..."
                 class="w-full"/>
        {{-- Sugestões --}}
        <ul x-show="filteredCriteria.length > 0 || searchingCriterion"
            class="max-h-60 overflow-y-auto mt-2 border rounded bg-gray-50 shadow-sm">
            <template x-if="searchingCriterion">
                <li class="p-2 text-gray-500">Buscando...</li>
            </template>
            <template x-for="criterion in filteredCriteria" :key="criterion.id">
                <li class="p-2 border-b cursor-pointer hover:bg-blue-100"
                    @click="addCriterion(criterion)">
                    <span x-text="criterion.name"></span>
                </li>
            </template>
        </ul>
        <template x-if="!filteredCriteria.length && searchCriterion && !searchingCriterion && showNoCriteriaMsg">
            <p class="p-2 text-gray-500">Nenhum critério encontrado.</p>
        </template>
    </div>

    {{-- Critérios selecionados --}}
    <div x-show="selectedCriteria.length > 0" class="mt-4">
        <h4 class="font-semibold mb-2">Critérios selecionados:</h4>
        <ul class="border rounded divide-y">
            <template x-for="criterion in selectedCriteria" :key="criterion.id">
                <li
                    class="flex justify-between items-center p-2 hover:bg-gray-100 transition"
                >
                    <div class="flex flex-col">
                        <span class="font-medium text-gray-800" x-text="criterion.name"></span>
                        <template x-if="criterion.description">
                            <span class="text-sm text-gray-500" x-text="criterion.description"></span>
                        </template>
                    </div>

                    <button
                        class="text-red-500 hover:text-red-700 font-bold text-lg"
                        @click="removeCriterion(criterion.id)"
                        title="Remover critério"
                    >
                        ✕
                    </button>
                </li>
            </template>
        </ul>
    </div>

</div>
