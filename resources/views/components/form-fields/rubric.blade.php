<div>
    <div>
        <x-label value="Tipo de Avaliação" class="mb-2 font-semibold" />
        <div class="flex items-center gap-x-6">
            <div class="flex items-center">
                <input id="individual" type="radio" value="individual" x-model="rubric.type"
                       class="h-4 w-4 text-secondary-blue focus:ring-secondary-blue border-gray-300">
                <label for="individual" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-200 cursor-pointer">
                    Individual
                </label>
            </div>
            <div class="flex items-center">
                <input id="in group" type="radio" value="in group" x-model="rubric.type"
                       class="h-4 w-4 text-secondary-blue focus:ring-secondary-blue border-gray-300">
                <label for="in group" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-200 cursor-pointer">
                    Em Grupo
                </label>
            </div>
        </div>
        {{-- Exibição de erro para o campo 'type', caso o backend retorne um --}}
        <template x-if="errors.type">
            <x-form-fields.field-error x-text="errors.type[0]"/>
        </template>
    </div>

    <div class="mt-4">
        <x-label for="name" value="Nome da Rubrica" />
        <x-input id="name" type="text" class="w-full mt-1"
                 placeholder="Ex: Rubrica de Avaliação do Projeto Integrador"
                 x-model="rubric.name"
                 @keydown.enter="saveRubric" />
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>


    {{-- Campo de busca para os Eixos --}}
    <div class="pt-4">
        <x-label value="Adicionar Eixos à Rúbrica"/>
        <x-input id="searchAxis" type="search"
                 x-model="searchAxis"
                 placeholder="Buscar eixo por nome..."
                 class="w-full mt-1"/>
        {{-- Exibição de erro geral para os eixos (ex: "É necessário pelo menos um eixo") --}}
        <template x-if="errors.axes">
            <x-form-fields.field-error x-text="errors.axes[0]"/>
        </template>
    </div>

    {{-- Lista de sugestões de Eixos --}}
    <template x-if="!filteredAxes.length && searchAxis && !searching && showNoAxesMsg">
        <p class="p-2 text-gray-500">Nenhum eixo encontrado.</p>
    </template>
    <ul x-show="filteredAxes.length > 0 || searching" class="max-h-80 overflow-y-auto scrollbar-custom"
        x-bind:class="{ 'border rounded bg-gray-100 dark:bg-gray-700 shadow-sm dark:shadow-gray-700': filteredAxes.length > 0}"
    >
        <template x-if="searching">
            <li class="p-2 text-gray-500">Buscando...</li>
        </template>

        <template x-for="axis in filteredAxes" :key="axis.id">
            <li
                class="p-2 border-b border-gray-300 cursor-pointer hover:bg-gray-200/50 dark:hover:bg-gray-600"
                @click="addAxis(axis)"
            >
                <span x-text="axis.name"></span>
            </li>
        </template>
    </ul>

    <div x-show="axes.length > 0" class="pt-4">
        <h4 class="font-medium text-gray-700 dark:text-gray-200">Eixos selecionados:</h4>
        <ul class="space-y-1 mt-1">
            {{-- Para cada eixo na nossa lista 'axes'... --}}
            <template x-for="axis in axes" :key="axis.id">
                {{-- O item da lista agora usa flex para alinhar tudo na mesma linha --}}
                <li class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 px-4 rounded">

                    {{-- Um container para o nome do eixo e o seu campo de peso --}}
                    <div class="flex items-center flex-grow gap-4">
                        <span x-text="axis.name" class="flex-shrink-0"></span>

                        {{-- Campo para definir o peso do eixo --}}
                        <div class="flex items-center gap-2 ml-auto">
                            <label :for="'weight-' + axis.id" class="text-sm font-medium  text-gray-700 dark:text-gray-200">Peso:</label>
                            <input :id="'weight-' + axis.id"
                                   type="number"
                                   {{-- 'x-model' liga este input diretamente à propriedade 'weight' do objeto 'axis' --}}
                                   x-model="axis.weight"
                                   placeholder="%"
                                   min=0
                                   max= 100
                                   class="w-20 text-center border-gray-300  rounded-md shadow-sm h-8 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                        </div>
                    </div>

                    {{-- Botão para remover o eixo (agora com uma pequena margem à esquerda) --}}
                    <button @click="removeAxis(axis.id)"
                            title="Remover Eixo"
                            class="ml-4 text-red-500 hover:text-red-700 h-[20px] w-[20px] rounded-sm bg-red-100 flex-shrink-0">
                        ✕
                    </button>
                </li>
            </template>
        </ul>

        <div class="mt-2">
            <p class="text-sm"
               :class="totalWeight === 100 ? 'text-green-600' : 'text-red-600'">
                Soma total: <span x-text="totalWeight"></span>%
            </p>
            <template x-if="totalWeight !== 100">
                <p class="text-xs text-red-500">A soma dos pesos deve ser exatamente 100%</p>
            </template>
        </div>

        {{-- Exibição de erro para os pesos (ex: "Todos os eixos devem ter um peso") --}}
        <template x-if="errors.axes_weights">
            <p class="text-sm text-red-600" x-text="errors.axes_weights[0]"></p>
        </template>
    {{-- Timestamps --}}
    </div>

    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>

</div>
