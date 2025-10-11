<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo aluno</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do aluno</span>
            </template>
        </x-slot>

        <x-slot name="content">
            {{-- Banner de mensagem --}}
            <x-custom-banner/>
            {{-- Formulário --}}
            <div>
                <x-form-fields.student/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                x-on:click="
                    saveStudent;
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

    <div x-show="!isEmpty && !loading" class="py-5 px-2 rounded-sm">
        {{-- Tabela de registros: recebe os dados iniciais direto do controller e na paginação recebe os dados pro ajax --}}
        <x-table.content
            :items="'students'"
            :new-items="'newStudents'"
            :item-key="'ra'"
            :haveActions="true"
        >
            <x-slot name="columns">
                <x-table.th class="hidden md:table-cell">RA</x-table.th>
                <x-table.th  >Nome</x-table.th >
                <x-table.th class=" hidden lg:table-cell">E-mail</x-table.th>
                <x-table.th class=" hidden md:table-cell">Grupo</x-table.th>
                <x-table.th class=" hidden xl:table-cell">Curso</x-table.th>
                <x-table.th class=" hidden xl:table-cell">Estado</x-table.th>
            </x-slot>

            <x-slot name="rows">
                <x-table.td class="hidden md:table-cell" x-text="item.ra"></x-table.td>
                <x-table.td x-text="item.name"></x-table.td>
                <x-table.td class="hidden lg:table-cell" x-text="item.email"></x-table.td>
                <x-table.td class="hidden md:table-cell" x-bind:class="item.group && item.group.state === 0 ? 'line-through text-gray-400' : ''" x-text="item.group?.name || '-'"></x-table.td>
                <x-table.td class="hidden xl:table-cell" x-bind:class="item.course && item.course.state === 0 ? 'line-through text-gray-400' : ''" x-text="item.course?.name || '-'"></x-table.td>
                <x-table.td class="hidden xl:table-cell" x-text="item.state === 1 ? 'Ativo' : 'Inativo'"></x-table.td>
            </x-slot>

            <x-slot name="actions">
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <template x-if="item.state">
                        <x-button type="button" class="min-w-[98px]"
                                  x-on:click="
                                    showStudent(item.user_id);
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
                                    warning('confirmação', item.name, item.user_id, 'ativar');
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
        </x-table.content>
    </div>
</div>
