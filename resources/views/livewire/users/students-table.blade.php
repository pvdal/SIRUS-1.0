<div>
    <div class="flex flex-wrap pt-4 ps-2 pe-2 sm:ps-8 sm:me-8">
        <x-button
            id="create"
            type="button"
            wire:click="openModal('create')"
            x-on:click="$el.blur()"
            class="min-h-10 me-2 mb-2 min-w-[168px]"
        >
            Cadastrar aluno
        </x-button>


        <x-input
            id="search"
            type="search"
            wire:model.live="searchTerm"
            class="w-full xs:w-4/12 me-2 mb-2 min-w-[168px] max-w-[168px] xs:max-w-full"
            placeholder="Buscar por nome..."
        />

        <select
            id="statusFilter"
            wire:model.live="statusFilter"
            class="appearance-none border border-gray-300 rounded-lg px-4 py-2.5 pr-10 me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue min-w-[168px] cursor-pointer"
        >
            <option value="">Todos</option>
            <option value="1">Apenas ativos</option>
            <option value="0">Apenas inativos</option>
        </select>

        <select
            id="registerperiod"
            wire:model="registerPeriod"
            class="appearance-none border border-gray-300 rounded-lg px-4 py-2.5 pr-10 me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue min-w-[168px] cursor-pointer"
        >
            <option value="">Todas as datas</option>
            <option value="today">Cadastrados hoje</option>
            <option value="week">Últimos 7 dias</option>
            <option value="month">Últimos 30 dias</option>
        </select>

        <button
            id="clearAction"
            type="button"
            wire:click="resetForm('filters')"
            class="appearance-none border border-gray-300 rounded-lg px-6 py-2.5 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue min-w-[168px] cursor-pointer inline-flex items-center justify-between gap-2"
        >
            Limpar filtros
            <x-lucide-trash-2 class="w-4 h-4 text-gray-500"/>
        </button>
    </div>

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
