<div>
    {{-- Modal de cadastro/edição para eixos --}}
    <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo Eixo</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do eixo</span>
            </template>
        </x-slot>

        <x-slot name="content">
            <x-custom-banner/>
            <div>
                <x-form-fields.axi/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                                x-on:click="saveAxes(); $el.blur();">
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-secondary-button>
            <x-danger-button type="button"
                             x-on:click="showCreateModal = false; clearFields('store');">
                Fechar
            </x-danger-button>
        </x-slot>
    </x-custom-modal>

    {{-- Avisos --}}
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
                                 x-on:click="toggleStatus(); $el.blur();"
                                 x-text="warningAction">
                </x-danger-button>
            </template>
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="ms-4">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>

    <div x-show="!isEmpty && !loading" class="py-5 px-2 rounded-sm">
        {{-- Tabela de registros: recebe os dados iniciais direto do controller e na paginação recebe os dados por ajax --}}
        <x-table.content
            :items="'axes'"
            :new-items="'newAxes'"
            :item-key="'id'"
            :haveActions="true"
        >
            <x-slot name="columns">
                <x-table.th>ID</x-table.th>
                <x-table.th>Nome</x-table.th>
                <x-table.th class="hidden sm:table-cell">Quantidade de Critérios</x-table.th>
                <x-table.th class="hidden sm:table-cell">Status</x-table.th>
            </x-slot>
            <x-slot name="rows">
                <x-table.td x-text="item.id"></x-table.td>
                <x-table.td x-text="item.name"></x-table.td>
                <x-table.td class="hidden sm:table-cell" x-text="item.amount || 0"></x-table.td>
                <x-table.td class="hidden sm:table-cell" x-text="item.state == 1 ? 'Ativo' : 'Inativo'"></x-table.td>
            </x-slot>
            <x-slot name="actions">
                <div class="flex flex-wrap gap-2 items-center justify-center">
                    <template x-if="item.state">
                        <x-button type="button" class="min-w-[98px]" x-on:click="showAxis(item.id)">
                            Alterar
                        </x-button>
                    </template>
                    <template x-if="item.state">
                        <x-danger-button type="button" class="min-w-[98px]"
                                         x-on:click="warning('confirmação', item.name, item.id, 'inativar')">
                            Inativar
                        </x-danger-button>
                    </template>
                    <template x-if="!item.state">
                        <x-management.activate-button type="button" class="min-w-[98px]"
                                                      x-on:click="warning('confirmação', item.name, item.id, 'ativar')">
                            Ativar
                        </x-management.activate-button>
                    </template>
                </div>
            </x-slot>

        </x-table.content>
    </div>
</div>
