<div>
    {{-- Nome do Eixo --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Eixo"/>
        <x-input id="name" type="text" autocomplete="off" class="w-full mt-1"
                 placeholder="Ex: Formatação e Apresentação"
                 x-model="name"
                 @keydown.enter.prevent="saveAxes()"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]" />
        </template>
    </div>

    {{-- Buscar Critérios --}}
    <div class="mt-4">
        <x-label value="Buscar Critérios" />
        <x-input type="text"
                 x-model="searchCriterion"
                 placeholder="Digite o nome do critério..."
                 class="w-full mt-1"/>
        <template x-if="errors.criteria">
            <x-form-fields.field-error x-text="errors.criteria[0]" />
        </template>
    </div>
    {{-- Lista de sugestões --}}
    <template x-if="!filteredCriteria.length && searchCriterion && !searchingCriterion && showNoCriteriaMsg">
        <p class="p-2 text-gray-500">Nenhum critério encontrado.</p>
    </template>
    <ul x-show="filteredCriteria.length > 0 || searchingCriterion" class="max-h-80 overflow-y-auto scrollbar-custom"
        x-bind:class="{ 'border rounded bg-gray-100 dark:bg-gray-700 shadow-sm dark:shadow-gray-700': filteredCriteria.length > 0}"
    >
        <template x-if="searchingCriterion">
            <li class="p-2 text-gray-500">Buscando...</li>
        </template>
        <template x-for="criterion in filteredCriteria" :key="criterion.id">
            <li
                class="p-2 border-b border-gray-300 cursor-pointer hover:bg-gray-200/50 dark:hover:bg-gray-600"
                @click="addCriterion(criterion)"
            >
                <span x-text="criterion.name"></span>
            </li>
        </template>
    </ul>

    {{-- Critérios selecionados --}}
    <x-form-fields.selected-list
        :title="'Critérios selecionados:'"
        :list="'selectedCriteria'"
        :key="'id'"
    >
        <span class="flex flex-col">
            <span x-text="item.name"></span>
            <template x-if="item.description">
                <span x-text="item.description"></span>
            </template>
        </span>
        <x-form-fields.remove-button :action="'removeCriterion'" :key="'item.id'"/>
    </x-form-fields.selected-list>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
