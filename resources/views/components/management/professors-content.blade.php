<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo professor</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do professor</span>
            </template>
        </x-slot>

        <x-slot name="content">
            {{-- Banner de mensagem --}}
            <x-custom-banner/>
            {{-- Formulário --}}
            <div>
                <x-form-fields.professor/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                x-on:click="
                    saveProfessor();
                    $el.blur();
                "
            >
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-secondary-button>
            <x-danger-button type="button"
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
    <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields('warning');" :maxWidth="'lg'" :warningType="'warningType'">
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
                    x-on:click="
                        toggleStatus();
                        $el.blur();
                    "
                    x-text="warningAction"
                >
                </x-danger-button>
            </template>
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="min-w-[98px]">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>
    <div x-show="!isEmpty && !loading" class="py-5 px-2">
        {{-- Tabela de registros: recebe os dados iniciais direto do controller e na paginação recebe os dados pro ajax --}}
        <x-table.content
            :items="'professors'"
            :new-items="'newProfessors'"
            :item-key="'id'"
            :haveActions="true"
            :multi-lines="true"
        >
            <x-slot name="columns">
                <x-table.th class="w-10"></x-table.th> {{-- Coluna para o botão de expandir --}}
                <x-table.th class="hidden md:table-cell ">ID</x-table.th>
                <x-table.th>Nome</x-table.th>
                <x-table.th class="hidden sm:table-cell">Email</x-table.th>
                <x-table.th class="hidden lg:table-cell">Formação</x-table.th>
                <x-table.th class="hidden sm:table-cell">Estado</x-table.th>
            </x-slot>
            <x-slot name="rows">
                <x-table.td class="w-10">
                    <button
                        type="button"
                        x-on:click="item.expanded = !item.expanded"
                        class="p-1 rounded hover:bg-gray-200 dark:hover:bg-gray-700 transition"
                        x-show="Object.values(item.education).reduce((t, e) => t + e.length, 0) > 0"
                    >
                        <svg
                            class="w-5 h-5 transition-transform duration-200"
                            :class="{ 'rotate-90': item.expanded }"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </x-table.td>
                <x-table.td class="hidden md:table-cell" x-text="item.id"></x-table.td>
                <x-table.td x-text="item.name"></x-table.td>
                <x-table.td class="hidden sm:table-cell" x-text="item.email"></x-table.td>
                <x-table.td class="hidden lg:table-cell"
                    x-text="Object.values(item.education).reduce((t, e) => t + e.length, 0) > 0 ?
                    Object.values(item.education).reduce((t, e) => t + e.length, 0) + ' Níveis':
                    ''
                ">
                </x-table.td>
                <x-table.td class="hidden sm:table-cell" x-text="item.state ? 'Ativo' : 'Inativo'"></x-table.td>
            </x-slot>
            <x-slot name="actions">
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <template x-if="item.state">
                        <x-button type="button" class="min-w-[98px]"
                            x-on:click="
                                showProfessor(item.user_id);
                                $el.blur();
                            "
                        >
                            Alterar
                        </x-button>
                    </template>

                    <template x-if="item.state">
                        <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(item.user_id)"
                                         x-on:click="
                                warning('confirmação', item.name, item.user_id, 'inativar');
                                $el.blur();
                            "
                        >
                            <template x-if="isInactivating(item.user_id)">
                                <span>Inativando...</span>
                            </template>
                            <template x-if="!isInactivating(item.user_id)">
                                <span>Inativar</span>
                            </template>
                        </x-danger-button>
                    </template>
                    <template x-if="!item.state">
                        <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(item.user_id)"
                                                      x-on:click="
                                warning('confirmação',item.name, item.user_id, 'ativar');
                                $el.blur();
                            "
                        >
                            <template x-if="isActivating(item.user_id)">
                                <span>Ativando...</span>
                            </template>
                            <template x-if="!isActivating(item.user_id)">
                                <span>Ativar</span>
                            </template>
                        </x-management.activate-button>
                    </template>
                </div>
            </x-slot>
            <x-slot name="addRows">
                <tr x-show="item.expanded" class="transition ease-in-out duration-150">
                    <td colspan="7" class="bg-gray-50/80 dark:bg-gray-900/40 px-6 py-4 transition ease-in-out duration-150">
                        <h1 class="text-base font-semibold text-gray-600 dark:text-gray-300 mb-2 transition ease-in-out duration-150">Níveis de formação</h1>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            {{-- Graduação --}}
                            <div class="bg-white dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700 transition ease-in-out duration-150">
                                <h4 class="font-semibold text-sm text-gray-500 dark:text-gray-400 mb-2 transition ease-in-out duration-150">Graduação</h4>
                                <template x-if="item.education.graduation && item.education.graduation.length > 0">
                                    <ul class="space-y-1">
                                        <template x-for="edu in item.education.graduation" :key="edu.id">
                                            <li class="text-base font-bold text-gray-700 dark:text-gray-300 transition ease-in-out duration-150" x-text="edu.course"></li>
                                        </template>
                                    </ul>
                                </template>
                                <template x-if="!item.education.graduation || item.education.graduation.length === 0">
                                    <span class="text-base text-gray-400">-</span>
                                </template>
                            </div>

                            {{-- Especialização --}}
                            <div class="bg-white dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700 transition ease-in-out duration-150">
                                <h4 class="font-semibold text-sm text-gray-500 dark:text-gray-400 mb-2 transition ease-in-out duration-150">Especialização</h4>
                                <template x-if="item.education.specialization && item.education.specialization.length > 0">
                                    <ul class="space-y-1">
                                        <template x-for="edu in item.education.specialization" :key="edu.id">
                                            <li class="text-base font-bold text-gray-700 dark:text-gray-300 transition ease-in-out duration-150" x-text="edu.course"></li>
                                        </template>
                                    </ul>
                                </template>
                                <template x-if="!item.education.specialization || item.education.specialization.length === 0">
                                    <span class="text-base text-gray-400">-</span>
                                </template>
                            </div>

                            {{-- Mestrado --}}
                            <div class="bg-white dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700 transition ease-in-out duration-150">
                                <h4 class="font-semibold text-sm text-gray-500 dark:text-gray-400 mb-2 transition ease-in-out duration-150">Mestrado</h4>
                                <template x-if="item.education.masters && item.education.masters.length > 0">
                                    <ul class="space-y-1">
                                        <template x-for="edu in item.education.masters" :key="edu.id">
                                            <li class="text-base font-bold text-gray-700 dark:text-gray-300 transition ease-in-out duration-150" x-text="edu.course"></li>
                                        </template>
                                    </ul>
                                </template>
                                <template x-if="!item.education.masters || item.education.masters.length === 0">
                                    <span class="text-base text-gray-400">-</span>
                                </template>
                            </div>

                            {{-- Doutorado --}}
                            <div class="bg-white dark:bg-gray-700/50 rounded-lg p-4 border border-gray-200 dark:border-gray-700 transition ease-in-out duration-150">
                                <h4 class="font-semibold text-sm text-gray-500 dark:text-gray-400 mb-2 transition ease-in-out duration-150">Doutorado</h4>
                                <template x-if="item.education.doctorate && item.education.doctorate.length > 0">
                                    <ul class="space-y-1">
                                        <template x-for="edu in item.education.doctorate" :key="edu.id">
                                            <li class="text-base font-bold text-gray-700 dark:text-gray-300 transition ease-in-out duration-150" x-text="edu.course"></li>
                                        </template>
                                    </ul>
                                </template>
                                <template x-if="!item.education.doctorate || item.education.doctorate.length === 0">
                                    <span class="text-base text-gray-400">-</span>
                                </template>
                            </div>
                        </div>
                    </td>
                </tr>
            </x-slot>
        </x-table.content>
    </div>
</div>
