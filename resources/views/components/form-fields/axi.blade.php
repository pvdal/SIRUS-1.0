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
                x-on:remove-criterion.window="
                    if($event.detail === criterion.id) {
                        criterion.belongsTo = false;
                    }
                "
                x-on:click="
                    if(!criterion.belongsTo) {
                        addCriterion(criterion);
                        criterion.belongsTo = true;
                    }
                "
                :class="{
                    'line-through opacity-60 bg-gray-200/50 dark:bg-gray-600 !cursor-default ': criterion.belongsTo
                }"
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
        <span class="ms-1 flex flex-wrap overflow-hidden max-w-[90%]">
            <span class="truncate block xs:whitespace-normal max-w-full" x-text="item.name"></span>
            <template x-if="item.description">
                <span class="truncate block xs:whitespace-normal max-w-full ml-1" x-text="'- ' + item.description"></span>
            </template>
        </span>
        <x-form-fields.remove-button class="ms-5" :action="'removeCriterion'" :additional="'$dispatch(\'remove-criterion\',item.id);'" :key="'item.id'"/>
    </x-form-fields.selected-list>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
