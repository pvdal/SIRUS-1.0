<div>
    {{-- Modal de cadastro/edição para Critérios --}}
    <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo critério</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do critério</span>
            </template>
        </x-slot>

        <x-slot name="content">
            {{-- Banner de mensagem --}}
            <x-custom-banner/>
            {{-- Formulário de Critério --}}
            <div>
                {{-- Componente de formulário do Critério--}}
                <x-form-fields.criterion/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                x-on:click="
                    saveCriterion();
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

    {{-- Component modal para avisos (reutilizável) --}}
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
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="ms-4">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>

    <div x-show="!isEmpty && !loading" class="py-5 px-2 rounded-sm">
        {{-- Tabela de registros de critérios: recebe os dados iniciais direto do controller e na paginação recebe os dados por ajax --}}
        <x-table.content
            :items="'criteria'"
            :new-items="'newCriteria'"
            :item-key="'id'"
            :haveActions="true"
        >
            <x-slot name="columns">
                <x-table.th >ID</x-table.th>
                <x-table.th >Nome</x-table.th>
                <x-table.th class="hidden md:table-cell">Insatisfatório</x-table.th>
                <x-table.th class="hidden md:table-cell">Satisfatório</x-table.th>
                <x-table.th class="hidden md:table-cell">Bom</x-table.th>
                <x-table.th class="hidden md:table-cell">Excelente</x-table.th>
                <x-table.th class="hidden sm:table-cell">Estado</x-table.th>
            </x-slot>
            <x-slot name="rows">
                <x-table.td x-text="item.id"></x-table.td>
                <x-table.td x-text="item.name"></x-table.td>
                <x-table.td class="hidden md:table-cell truncate max-w-[200px]" x-bind:title="item.unsatisfactory" x-text="item.unsatisfactory || '-'"></x-table.td>
                <x-table.td class="hidden md:table-cell truncate max-w-[200px]" x-bind:title="item.satisfactory" x-text="item.satisfactory || '-'"></x-table.td>
                <x-table.td class="hidden md:table-cell truncate max-w-[200px]" x-bind:title="item.good" x-text="item.good || '-'"></x-table.td>
                <x-table.td class="hidden md:table-cell truncate max-w-[200px]" x-bind:title="item.excellent" x-text="item.excellent || '-'" ></x-table.td>
                <x-table.td class="hidden sm:table-cell" x-text="item.state ? 'Ativo' : 'Inativo'"></x-table.td>
            </x-slot>
            <x-slot name="actions">
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <template x-if="item.state">
                        <x-button type="button" class="min-w-[98px]"
                                  x-on:click="
                                    showCriterion(item);
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
                            <span x-show="isInactivating(item.id)">Inativando...</span>
                            <span x-show="!isInactivating(item.id)">Inativar</span>
                        </x-danger-button>
                    </template>
                    <template x-if="!item.state">
                        <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(item.id)"
                                                      x-on:click="
                                    warning('confirmação', item.name, item.id, 'ativar');
                                    $el.blur();
                                "
                        >
                            <span x-show="isActivating(item.id)">Ativando...</span>
                            <span x-show="!isActivating(item.id)">Ativar</span>
                        </x-management.activate-button>
                    </template>
                </div>
            </x-slot>
        </x-table.content>
    </div>
</div>
