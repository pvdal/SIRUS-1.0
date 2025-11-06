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
            <x-secondary-button type="button" x-bind:disabled="saving"
                x-on:click="
                    saveGroup();
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
    <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields('warning');" :maxWidth="'sm'" :warningType="'warningType'">
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
    {{-- View dos cards --}}
    <div x-show="!isEmpty && !loading" class="mx-auto p-6">
        <x-card.grid
            :items="'groups'"
            :new-items="'newGroups'"
            :item-key="'id'"
        >
            <x-card.layout>
                <x-card.content :members-count="'students'">
                    <x-slot name="header">
                        <span x-text="item.id" class="text-sm text-gray-600 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                    </x-slot>

                    <x-slot name="title">
                        <h3 class="text-lg font-semibold line-clamp-2 leading-snug " x-text="item.theme"></h3>
                    </x-slot>

                    <x-slot name="members">
                        <template x-for="student in item.students" :key="student.ra">
                            <li
                                x-text="student.name"
                                :class="student.state == 0 ? 'line-through text-gray-400' : ''"
                            ></li>
                        </template>
                    </x-slot>

                    <x-slot name="paperAction">
                        <template x-if="item?.papers?.length && item.papers[item.papers.length -1]?.file_path">
                            <x-card.link-button
                                x-on:click="showPaper(`${item.papers[item.papers.length -1]?.file_path}`)"
                            >
                                <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 transition duration-150 ease-in-out flex-shrink-0"/>
                                <span class="text-sm text-gray-800 dark:text-gray-200 transition duration-150 ease-in-out font-semibold truncate" x-text="item.papers[item.papers.length -1]?.title"></span>
                            </x-card.link-button>
                        </template>
                    </x-slot>

                    <x-slot name="state">
                        <span
                            class=" inline-flex text-xs py-1 ms-4 px-3 font-bold rounded-s-lg rounded-e-lg transition duration-150 ease-in-out"
                            :class="item?.state === 1
                            ? 'bg-secondary-blue text-white dark:text-gray-200'
                            : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-200'"
                            x-text="item?.state === 1 ? 'Ativo' : 'Inativo'">
                        </span>
                    </x-slot>

                    <x-slot name="actions">
                        <template x-if="item.state">
                            <x-button type="button" class="min-w-[90px]"
                                      x-on:click="
                                showGroup(item.id)
                                $el.blur();
                            "
                            >
                                Alterar
                            </x-button>
                        </template>
                        <template x-if="item.state">
                            <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(item.id)"
                                             x-on:click="
                                warning('confirmação', item.theme, item.id, 'inativar');
                                $el.blur();
                            "
                            >
                                <template x-if="isInactivating(item.id)">
                                    <span>Inativando...</span>
                                </template>
                                <template x-if="!isInactivating(item.id)">
                                    <span>Inativar</span>
                                </template>
                            </x-danger-button>
                        </template>
                        <template x-if="!item.state">
                            <x-management.activate-button type="buton" class="min-w-[98px]" x-bind:disabled="isActivating(item.id)"
                                                          x-on:click="
                                warning('confirmação',item.theme, item.id, 'ativar');
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
                </x-card.content>
            </x-card.layout>
        </x-card.grid>
    </div>
</div>
