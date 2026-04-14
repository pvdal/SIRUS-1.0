<div>
    <div>
        <h2 class="mb-2 font-semibold text-sm text-gray-700 dark:text-gray-300 transition">Tipo de Avaliação</h2>
        <div class="flex items-center gap-x-6">
            <div class="flex items-center">
                <input id="individual" type="radio" value="2" x-model="rubric.type"
                       class="h-4 w-4 dark:accent-gray-700 checked:accent-secondary-blue text-secondary-blue focus:ring-secondary-blue dark:focus:ring-offset-gray-800 border-gray-300">
                <label for="individual" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-200 cursor-pointer">
                    Individual
                </label>
            </div>
            <div class="flex items-center">
                <input id="in-group" type="radio" value="1" x-model="rubric.type"
                       class="h-4 w-4 dark:accent-gray-700 checked:accent-secondary-blue text-secondary-blue focus:ring-secondary-blue dark:focus:ring-offset-gray-800 border-gray-300">
                <label for="in-group" class="ml-2 block text-sm font-medium text-gray-700 dark:text-gray-200 cursor-pointer">
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
                 x-model="rubric.name" autocomplete="none"
                 @keydown.enter="saveRubric" />
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>


    {{-- Campo de busca para os Eixos --}}
    <div class="pt-4">
        <x-label for="searchAxis" value="Adicionar Eixos à Rubrica"/>
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
                x-on:click="
                    if(!axis.belongsTo) {
                        addAxis(axis);
                        axis.belongsTo = true;
                    }
                "
                x-on:remove-axis.window="
                    if($event.detail === axis.id) {
                        axis.belongsTo = false;
                    }
                "
                :class="{
                    'line-through opacity-60 bg-gray-200/50 dark:bg-gray-600 !cursor-default ': axis.belongsTo
                }"
            >
                <span x-text="axis.name"></span>
            </li>
        </template>
    </ul>

    <div x-show="axes.length > 0" class="pt-4">
        <h4 class="font-medium text-gray-700 dark:text-gray-200">Eixos selecionados:</h4>
        <ul class="space-y-1 mt-1">
            {{-- Para cada eixo na lista 'axes'... --}}
            <template x-for="(axis, index) in axes" :key="axis.id">
                <div>
                    {{-- O item da lista agora usa flex para alinhar tudo na mesma linha --}}
                    <li class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 px-4 rounded">

                        {{-- Um container para o nome do eixo e o seu campo de peso --}}
                        <div class="flex flex-wrap items-center flex-grow gap-4">
                            <span x-text="axis.name"
                                  class="mr-auto line-clamp-2"
                            ></span>

                            {{-- Campo para definir o peso do eixo --}}
                            <div class="flex flex-wrap items-center gap-2">
                                <x-label x-bind:for="'weight-' + axis.id">Peso:</x-label>
                                <x-input x-bind:id="'weight-' + axis.id" type="text" {{-- x-input já tem formatação para tema escuro --}}
                                    @input="
                                       axis.weight = axis.weight.replace(/\D/g, '');
                                       if (axis.weight > 100) axis.weight = 100;
                                    " {{-- Alguns navegadores não respeitam o type number, com essa linha toda entrada alfabética é removida --}}
                                    {{-- 'x-model' liga este input diretamente à propriedade 'weight' do objeto 'axis' --}}
                                    x-model="axis.weight"
                                    placeholder="%"
                                    class="w-16 text-center text-sm h-8"
                                />
                            </div>
                        </div>
                        {{-- Botão para remover o eixo (agora com uma pequena margem à esquerda) --}}
                        <x-form-fields.remove-button
                            class="ms-5"
                            :action="'removeAxis'"
                            :additional="'$dispatch(\'remove-axis\', axis.id);'"
                            title="Remover Eixo"
                            :key="'axis.id'"/>
                    </li>
                    {{-- Exibição de erro para os pesos (ex: "Todos os eixos devem ter um peso") --}}
                    <template x-if="axes.length > 0 && errors && errors['axes.' + index + '.weight']">
                        {{-- Erro normalizado, vem do back com chave string, exemplo: axes.1.weight
                             o index torna possível exibir um campo de erro para cada item do loop.
                             OBS: O 'template' só suporta um elemento, por isso cerquei esse conteúdo
                             com um contêiner --}}
                        <x-form-fields.field-error x-text="errors['axes.' + index + '.weight']?.[0]"/>
                    </template>
                    <template x-if="axes.length > 0 && errors && errors['axes.' + index + '.id']">
                        <x-form-fields.field-error x-text="errors['axes.' + index + '.id']?.[0]"/>
                    </template>
                </div>
            </template>
        </ul>

        <div class="mt-6">
            <p class="text-sm"
               :class="totalWeight === 100 ? 'text-green-600' : 'text-red-600 dark:text-red-400'">
                Soma total: <span x-text="totalWeight"></span>%
            </p>
            <template x-if="totalWeight !== 100">
                <p class="text-xs text-red-500 dark:text-red-300">A soma dos pesos deve ser exatamente 100%</p>
            </template>
        </div>
    </div>

    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>

</div>
