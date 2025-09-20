<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" maxWidth="3xl">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo grupo</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do grupo</span>
            </template>
        </x-slot>

        <x-slot name="content">
            {{-- Banner de mensagem --}}
            <x-custom-banner/>
            {{-- Formulário --}}
            <div>
                <x-form-fields.group :courses="$courses" />
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving" class="min-w-[110px]"
                x-on:click="
                    saveGroup;
                    $el.blur();
                "
            >
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-secondary-button>
            <x-danger-button type="button" class="min-w-[110px]"
                x-on:click="
                    showCreateModal = false;
                    clearFields('store');
                "
            >
                Fechar
            </x-danger-button>
        </x-slot>
    </x-custom-modal>
    {{-- Component modal para avisos --}}
    <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields('warning');" :maxWidth="'sm'">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <template x-if="warningType === 'Confirmação'">
                    <div class="flex items-center gap-2 text-secondary-orange">
                        <div class="bg-secondary-orange rounded-[20px] p-2">
                            <x-lucide-alert-triangle class="text-white w-5 h-5" />
                        </div>
                        <span x-text="warningType" class="font-semibold"></span>
                    </div>
                </template>
                <template x-if="warningType === 'Erro'">
                    <div class="flex items-center gap-2 text-red-700">
                        <div class="bg-red-700 rounded-[20px] p-2">
                            <x-lucide-x-circle class="text-white w-5 h-5" />
                        </div>
                        <span x-text="warningType" class="font-semibold"></span>
                    </div>
                </template>
            </div>
        </x-slot>

        <x-slot name="content">
            <template x-if="warningContent">
                <p x-text="warningContent"></p>
            </template>
        </x-slot>

        <x-slot name="footer">
            <template x-if="warningType === 'Confirmação'">
                <x-danger-button type="button"
                    x-on:click="
                        toggleStatus();
                        $el.blur();
                    "
                    x-text="warningAction"
                >
                </x-danger-button>
            </template>
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="ms-4">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>
    {{-- View dos cards --}}
    <template x-if="showGroupCards">
        <div class="mx-auto p-6">
            <div class="flex flex-col items-center md:grid md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-4">
                <template x-for="group in [...newGroups, ...groups]" :key="group.id">
                    {{-- Card --}}
                    <div class="flex flex-col justify-between border border-gray-300 rounded-lg shadow bg-white/80 hover:bg-gray-50
                         w-full xs:w-[400px] md:w-auto max-w-[450px] backdrop-blur-sm transition-all duration-300 h-90 xxs:h-80 overflow-hidden hover:shadow-md"
                         x-bind:class="{ '!bg-green-50': group.origin === 'new' }">
                        <div class="max-h-[30px] w-full flex items-center px-6">
                            <span x-text="group.id" class="text-sm text-gray-600"></span>
                        </div>

                        <hr class="mt-0 block">
                        {{-- Cabeçalho --}}
                        <div class="flex justify-start items-center text-gray-800 h-[5rem] py-5 px-6 rounded-t-lg max-w-full">
                            <h3 class="text-lg font-semibold line-clamp-2 leading-snug" x-text="group.theme"></h3>
                        </div>
                        <hr class="border-t mb-2 mx-3"/>

                        {{-- Corpo, com total de membros --}}
                        <div class="flex items-center gap-1 text-sm text-gray-700 font-medium px-6 pb-2">
                            <x-lucide-users class="w-4 h-4 text-gray-500" />
                            <span x-text="`${group.students.length} ${group.students.length === 1 ? 'Membro' : 'Membros'}`"></span>
                        </div>

                        {{-- Lista de alunos --}}
                        <div class="overflow-auto flex-1 scrollbar-custom border px-6 mx-5 rounded-md">
                            <ul class="space-y-1 text-gray-600 text-sm py-1">
                                <template x-for="student in group.students" :key="student.ra">
                                    <li
                                        x-text="student.name"
                                        :class="student.state == 0 ? 'line-through text-gray-400' : ''"
                                    ></li>
                                </template>
                            </ul>
                        </div>

                        {{-- Ações do trabalho --}}
                        <div class="min-w-full px-3 py-1">
                            <template x-if="group.papers.length">
                                <button
                                    type="button"
                                    class="flex items-center justify-start gap-2 px-3 py-2 rounded-md hover:bg-gray-200 transition cursor-pointer w-full max-w-full"
                                    x-on:click="showPaper(`/${group.papers[0].file_path}`)"
                                >
                                    <x-lucide-file-text class="w-4 h-4 text-gray-600 flex-shrink-0"/>
                                    <span class="text-sm text-gray-800 font-semibold truncate " x-text="group.papers[0].title"></span>
                                    <x-lucide-link class="w-4 h-4 text-gray-600 flex-shrink-0 ms-auto"/>
                                </button>
                            </template>
                        </div>
                        <hr class="border-t border-gray-300 mx-3" />

                        {{-- Rodapé --}}
                        <div class="flex flex-wrap gap-3 items-center justify-between px-5 py-2">
                            <span
                                class="text-xs py-1 ms-4 px-3 font-bold rounded-s-lg rounded-e-lg"
                                :class="group.state === 1
                                    ? 'bg-secondary-blue text-white'
                                    : 'bg-gray-100 text-gray-600'"
                                x-text="group.state === 1 ? 'Ativo' : 'Inativo'"
                            ></span>

                            <div class="flex flex-wrap gap-2 ms-4">
                                <template x-if="group.state">
                                    <x-button type="button" class="min-w-[90px]"
                                        x-on:click="
                                            showGroup(group.id)
                                            $el.blur();
                                        "
                                    >
                                        Alterar
                                    </x-button>
                                </template>
                                <template x-if="group.state">
                                    <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(group.id)"
                                        x-on:click="
                                            warning('confirmação', group.theme, group.id, 'inativar');
                                            $el.blur();
                                        "
                                    >
                                        <template x-if="isInactivating(group.id)">
                                            <span>Inativando...</span>
                                        </template>
                                        <template x-if="!isInactivating(group.id)">
                                            <span>Inativar</span>
                                        </template>
                                    </x-danger-button>
                                </template>
                                <template x-if="!group.state">
                                    <x-management.activate-button type="buton" class="min-w-[98px]" x-bind:disabled="isActivating(group.id)"
                                        x-on:click="
                                            warning('confirmação',group.theme, group.id, 'ativar');
                                            $el.blur();
                                        "
                                    >
                                        <template x-if="isActivating(group.id)">
                                            <span>Ativando...</span>
                                        </template>
                                        <template x-if="!isActivating(group.id)">
                                            <span>Ativar</span>
                                        </template>
                                    </x-management.activate-button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </template>
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
                Nenhum grupo foi cadastrado até o momento.
            </p>
            <p class="text-gray-500 mt-1 text-sm">
                Assim que houverem grupos registrados, eles aparecerão aqui.
            </p>
        </div>
    </template>
</div>
