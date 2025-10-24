<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo curso</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do curso</span>
            </template>
        </x-slot>

        <x-slot name="content">
            {{-- Banner de mensagem --}}
            <x-custom-banner/>
            {{-- Formulário --}}
            <x-form-fields.course/>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                x-on:click="
                    saveCourse();
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
    <div x-show="!isEmpty && !loading" class="py-5 px-2">
        {{-- Tabela de registros: recebe os dados iniciais direto do controller e na paginação recebe os dados pro ajax --}}
        <x-table.content
            :items="'courses'"
            :new-items="'newCourses'"
            :item-key="'id'"
            :haveActions="true"
        >
            <x-slot name="columns">
                <x-table.th class="hidden md:table-cell">ID</x-table.th>
                <x-table.th>Nome</x-table.th >
                <x-table.th class=" hidden sm:table-cell">Turno</x-table.th>
                <x-table.th class=" hidden md:table-cell">Coordenador</x-table.th>
                <x-table.th class=" hidden md:table-cell">Estado</x-table.th>
            </x-slot>

            <x-slot name="rows">
                <x-table.td class="hidden md:table-cell" x-text="item.id"></x-table.td>
                <x-table.td x-text="item.name"></x-table.td>
                <x-table.td class="hidden sm:table-cell" x-text="item.shift_pt"></x-table.td>
                <x-table.td class="hidden md:table-cell" x-bind:class="item.coordinator_state === 0 && item.coordinator_name ? 'line-through text-gray-400' : ''" x-text="item.coordinator_name || '-'"></x-table.td>
                <x-table.td class="hidden md:table-cell" x-text="item.state === 1 ? 'Ativo' : 'Inativo'"></x-table.td>
            </x-slot>

            <x-slot name="actions">
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <template x-if="item.state">
                        <x-button type="button" class="min-w-[98px]"
                                  x-on:click="
                                    showCourse(item.id);
                                    $el.blur();
                                "
                        >
                            Alterar
                        </x-button>
                    </template>

                    <template x-if="item.state">
                        <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(item.id)"
                                         x-on:click="
                                    warning('confirmação', item.name, item.id, 'inativar');
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
                </div>
            </x-slot>
        </x-table.content>
    </div>
</div>
