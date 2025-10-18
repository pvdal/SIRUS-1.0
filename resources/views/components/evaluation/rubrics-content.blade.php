<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" maxWidth="3xl">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar nova Rubrica</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados da rubrica</span>
            </template>
        </x-slot>

        <x-slot name="content">
            <x-custom-banner/>
            <div>
                <x-form-fields.rubric />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                                x-on:click="saveRubric; $el.blur();">
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-secondary-button>
            <x-danger-button type="button"
                             x-on:click="
                             showCreateModal = false;
                             clearFields('store');">
                Fechar
            </x-danger-button>
        </x-slot>
    </x-custom-modal>


    {{-- Component modal para avisos --}}
    <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields();" :maxWidth="'sm'" :warningType="'warningType'">
        <x-slot name="title">
            <template x-if="warningType">
                <span x-text="warningType" class="font-semibold"></span>
            </template>
        </x-slot>

        <x-slot name="content">
            <template x-if="warningContent">
                <p x-text="warningContent"></p>
            </template>
        </x-slot>

        <x-slot name="footer">
            <template x-if="warningType === 'Confirmação'">
                <x-danger-button type="button"
                                 x-on:click="toggleStatus(); $el.blur();"
                                 x-text="warningAction">
                </x-danger-button>
            </template>
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields();" class="ms-4">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>
    {{-- View dos cards --}}
{{--    <template x-if="showRubricCards">--}}
{{--        <div class="mx-auto p-6">--}}
{{--            <div class="flex flex-col items-center md:grid md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-4">--}}

{{--                --}}{{-- MODIFICADO: Loop sobre as rúbricas em vez de grupos --}}
{{--                <template x-for="rubric in [...newRubrics, ...rubrics]" :key="rubric.id">--}}

{{--                    --}}{{-- Card da Rúbrica --}}
{{--                    <div class="flex flex-col justify-between border border-gray-300 rounded-lg shadow bg-white/80 hover:bg-gray-50--}}
{{--                         w-full xs:w-[400px] md:w-auto max-w-[450px] backdrop-blur-sm transition-all duration-300 h-90 xxs:h-80 overflow-hidden hover:shadow-md"--}}
{{--                         x-bind:class="{ '!bg-green-50': rubric.origin === 'new' }">--}}

{{--                        <div class="max-h-[30px] w-full flex items-center px-6">--}}
{{--                            --}}{{-- Mostra o ID da Rúbrica --}}
{{--                            <span x-text="'ID: ' + rubric.id" class="text-sm text-gray-600"></span>--}}
{{--                        </div>--}}

{{--                        <hr class="mt-0 block">--}}

{{--                        --}}{{-- Cabeçalho: Nome da Rúbrica --}}
{{--                        <div class="flex justify-start items-center text-gray-800 h-[5rem] py-5 px-6 rounded-t-lg max-w-full"--}}
{{--                             :title="rubric.description"> --}}{{-- NOVO: Tooltip com a descrição --}}
{{--                            <h3 class="text-lg font-semibold line-clamp-2 leading-snug" x-text="rubric.name"></h3>--}}
{{--                        </div>--}}
{{--                        <hr class="border-t mb-2 mx-3"/>--}}

{{--                        --}}{{-- Corpo: Total de Eixos --}}
{{--                        <div class="flex items-center gap-1 text-sm text-gray-700 font-medium px-6 pb-2">--}}
{{--                            <x-lucide-list-checks class="w-4 h-4 text-gray-500" /> --}}{{-- Ícone mais apropriado --}}
{{--                            <span x-text="`${rubric.axes.length} ${rubric.axes.length === 1 ? 'Eixo' : 'Eixos'}`"></span>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Lista de Eixos com Pesos --}}
{{--                        <div class="overflow-auto flex-1 scrollbar-custom border px-6 mx-5 rounded-md">--}}
{{--                            <ul class="space-y-1 text-gray-600 text-sm py-1">--}}
{{--                                <template x-for="axis in rubric.axes" :key="axis.id">--}}
{{--                                    <li class="flex justify-between">--}}
{{--                                        <span x-text="axis.name"></span>--}}
{{--                                        <span class="font-medium text-gray-800" x-text="`Peso: ${axis.weight}`"></span>--}}
{{--                                    </li>--}}
{{--                                </template>--}}
{{--                            </ul>--}}
{{--                        </div>--}}

{{--                        --}}{{-- Rodapé com Ações --}}
{{--                        <div class="flex flex-wrap gap-3 items-center justify-between px-5 py-3 mt-2 border-t">--}}
{{--                            <span--}}
{{--                                class="text-xs py-1 px-3 font-bold rounded-s-lg rounded-e-lg"--}}
{{--                                :class="rubric.state === 1--}}
{{--                                    ? 'bg-secondary-blue text-white'--}}
{{--                                    : 'bg-gray-100 text-gray-600'"--}}
{{--                                x-text="rubric.state === 1 ? 'Ativa' : 'Inativa'"--}}
{{--                            ></span>--}}

{{--                            <div class="flex flex-wrap gap-2">--}}
{{--                                --}}{{-- Botão Alterar --}}
{{--                                <template x-if="rubric.state">--}}
{{--                                    <x-button type="button" class="min-w-[90px]"--}}
{{--                                              x-on:click="--}}
{{--                                            editRubric(rubric); --}}{{-- MODIFICADO: Função para editar a rúbrica --}}
{{--                                            $el.blur();--}}
{{--                                        "--}}
{{--                                    >--}}
{{--                                        Alterar--}}
{{--                                    </x-button>--}}
{{--                                </template>--}}

{{--                                --}}{{-- Botão Inativar --}}
{{--                                <template x-if="rubric.state">--}}
{{--                                    <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(rubric.id)"--}}
{{--                                                     x-on:click="--}}
{{--                                            warning('Confirmação', `Deseja inativar a rúbrica '${rubric.name}'?`, rubric.id, 'inativar');--}}
{{--                                            $el.blur();--}}
{{--                                        "--}}
{{--                                    >--}}
{{--                                        <span x-show="isInactivating(rubric.id)">Inativando...</span>--}}
{{--                                        <span x-show="!isInactivating(rubric.id)">Inativar</span>--}}
{{--                                    </x-danger-button>--}}
{{--                                </template>--}}

{{--                                --}}{{-- Botão Ativar --}}
{{--                                <template x-if="!rubric.state">--}}
{{--                                    <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(rubric.id)"--}}
{{--                                                                  x-on:click="--}}
{{--                                            warning('Confirmação', `Deseja ativar a rúbrica '${rubric.name}'?`, rubric.id, 'ativar');--}}
{{--                                            $el.blur();--}}
{{--                                        "--}}
{{--                                    >--}}
{{--                                        <span x-show="isActivating(rubric.id)">Ativando...</span>--}}
{{--                                        <span x-show="!isActivating(rubric.id)">Ativar</span>--}}
{{--                                    </x-management.activate-button>--}}
{{--                                </template>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </template>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </template>--}}

    <div x-show="!isEmpty && !loading" class="mx-auto p-6">
        <x-card.grid
            :items="'rubrics'"
            :new-items="'newRubrics'"
            :item-key="'id'"
        >
            <x-card.layout>
                <x-card.content-rubric :axes-count="'axes'">
                    {{-- ID / Cabeçalho --}}
                    <x-slot name="header">
                        <span x-text="item.id" class="text-sm text-gray-600 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                    </x-slot>

                    {{-- Título / Nome da Rubrica --}}
                    <x-slot name="title">
                        <h3 class="text-lg font-semibold line-clamp-2 leading-snug" x-text="item.name"></h3>
                    </x-slot>

                    {{-- Lista dos Eixos da Rubrica --}}
                    <x-slot name="axes">
                        <template x-for="axis in item.axes" :key="axis.id">
                            <li x-text="axis.name"></li>
                        </template>
                    </x-slot>

                    {{-- (Opcional) Ação de abrir modelo da Rubrica --}}
                    <x-slot name="paperAction">
                        <x-card.link-button
                            x-on:click="
                        showRubricModel(item.id)
                    "
                        >
                            <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 transition duration-150 ease-in-out flex-shrink-0"/>
                            <span class="text-sm text-gray-800 dark:text-gray-200 font-semibold truncate">Ver Modelo</span>
                        </x-card.link-button>
                    </x-slot>

                    {{-- Estado (Ativo/Inativo) --}}
                    <x-slot name="state">
                <span
                    class="text-xs py-1 ms-4 px-3 font-bold rounded-s-lg rounded-e-lg transition duration-150 ease-in-out"
                    :class="item.state === 1
                        ? 'bg-secondary-blue text-white dark:text-gray-200'
                        : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200'"
                    x-text="item.state === 1 ? 'Ativo' : 'Inativo'">
                </span>
                    </x-slot>

                    {{-- Botões de Ações --}}
                    <x-slot name="actions">
                        <template x-if="item.state">
                            <x-button type="button" class="min-w-[90px]" x-on:click="showRubric(item.id);">
                                Alterar
                            </x-button>
                        </template>

                        <template x-if="item.state">
                            <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(item.id)"
                                             x-on:click="warning('confirmação', item.name, item.id, 'inativar');" >
                                <template x-if="isInactivating(item.id)">
                                    <span>Inativando...</span>
                                </template>
                                <template x-if="!isInactivating(item.id)">
                                    <span>Inativar</span>
                                </template>
                            </x-danger-button>
                        </template>

                        <template x-if="!item.state">
                            <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(item.id)"
                                                          x-on:click="
                        warning('confirmação', item.name, item.id, 'ativar');
                        $el.blur();
                    "
                            >
                                <template x-if="isActivating(item.id)">
                                    <span>Ativando...</span>
                                </template>
                                <template x-if="!isActivating(item.id)">
                                    <span>Ativar</span>
                                </template>
                            </x-management.activate-button>
                        </template>
                    </x-slot>
                </x-card.content-rubric>
            </x-card.layout>
        </x-card.grid>
    </div>
    {{-- Estado de Carregamento (Loading) --}}
    <div x-show="loading" class="flex justify-center py-4">
        <svg class="animate-spin h-6 w-6 text-secondary-blue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
            </path>
        </svg>
    </div>
    <template x-if="empty">
        <div class="flex flex-col items-center justify-center pb-8 text-center">
            <p class="text-gray-700 text-md font-medium">
                Nenhuma rubrica foi cadastrada até o momento.
            </p>
            <p class="text-gray-500 mt-1 text-sm">
                Assim que houverem rubricas registradas, elas aparecerão aqui.
            </p>
        </div>
    </template>
</div>
