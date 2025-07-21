<div>
    <x-actions-table-bar
        :primaryAction="['label' => 'Cadastrar Aluno', 'method' => 'openModal', 'param' => 'create']"
        :clearAction="['label' => 'Limpar filtros', 'method' => 'resetForm', 'param' => 'filters']"
        searchModel="searchTerm"
        searchPlaceholder="Buscar por nome..."
        statusFilter="statusFilter"
        registerPeriod="registerPeriod"
    >
        {{-- Slot de filtros customizados --}}
        <x-slot name="filters"></x-slot>
    </x-actions-table-bar>

@if($showCreateModal)
        <x-dialog-modal wire:model="showCreateModal">
            <x-slot name="title">
                Cadastre um aluno
            </x-slot>

            <x-slot name="content">
                <x-banner/>

                <x-form-fields.student typeModal="create"/>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button type="button" wire:click="store">
                    Salvar
                </x-secondary-button>
                <x-danger-button type="button" wire:click="closeModal('create')" class="ms-2">
                    Fechar
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif

    @if($showUpdateModal)
        <x-dialog-modal wire:model="showUpdateModal">
            <x-slot name="title">
                Atualizar Cadastro
            </x-slot>

            <x-slot name="content">
                <x-banner/>

                <x-form-fields.student typeModal="update"/>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button type="button" wire:click="update">
                    Salvar
                </x-secondary-button>
                <x-danger-button type="button" wire:click="closeModal('update')" class="ms-2">
                    Fechar
                </x-danger-button>
            </x-slot>
        </x-dialog-modal>
    @endif

    @if($showWarning)
        <x-confirmation-modal wire:model="showWarning" :maxWidth="'sm'" :icon="$warningType">
            <x-slot name="title">
                {{ $warningType }}
            </x-slot>
            <x-slot name="content" >
                {{ $warningContent }}
            </x-slot>
            <x-slot name="footer" >
                @if($warningType === 'Confirmação')
                    <x-danger-button id="Inactivate" type="button" wire:click="inactivate">
                        Inativar
                    </x-danger-button>
                @endif
                <x-secondary-button id="closeModalInactivation" type="button"  wire:click="closeModal('inactivation')" class="ms-4">
                    Voltar
                </x-secondary-button>
            </x-slot>
        </x-confirmation-modal>
    @endif

    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-5">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-center text-gray-700 hidden xs:table-cell">RA</th>
                <th class="px-4 py-2 text-center text-gray-700">Nome</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Email</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Semestre</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">Grupo</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Curso</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Estado</th>
                <th class="px-4 py-2 text-center text-gray-700">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white">
        @foreach ($students as $student)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center border-gray-300 hidden xs:table-cell">{{ $student->ra }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">{{ $student->user->name }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $student->user->email }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $student->semester }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $student->group_id }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $student->course_id }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $student->user->state == 1 ? 'Ativo' : 'Inativo' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button
                        id="openModalUpdate"
                        type="button"
                        wire:click="openModal('update',{{ $student->ra }})"
                        class="min-w-[98px]"
                        x-on:click="$el.blur()"
                    >
                        Alterar
                    </x-button>
                    @if($student->user->state == 1)
                        <x-danger-button
                            id="openModalInactivation"
                            type="button"
                            wire:click="openModal('inactivation',{{ $student->ra }})"
                            x-on:click="$el.blur()"
                        >
                            Inativar
                        </x-danger-button>
                    @else
                        <x-danger-button
                            id="openModalActivation"
                            type="button"
                            wire:click="activate({{ $student->ra }})"
                            class="min-w-[98px]"
                            x-on:click="$el.blur()"
                        >
                            Ativar
                        </x-danger-button>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="p-2 flex justify-center mt-2 mb-4">
        {{ $students->links() }}
    </div>
</div>
