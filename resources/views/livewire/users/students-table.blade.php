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

                <div>
                    <x-label for="ra" value="RA"/>
                    <x-input id="ra" class="w-full" type="number" wire:model.lazy="ra" wire:keydown="resetError('ra')" wire:change="validateRa" onkeydown="return ['e','E','+','-'].indexOf(event.key) === -1"/>
                </div>
                <x-input-error :for="'ra'"/>

                <div class="mt-4">
                    <x-label for="name" value="Nome"/>
                    <x-input id="name" class="w-full" type="text" wire:model="name"/>
                </div>
                <x-input-error :for="'name'"/>

                <div class="mt-4">
                    <x-label for="email" value="E-mail"/>
                    <x-input id="email" class="w-full" type="email" wire:model.lazy="email" wire:keydown="resetError('email')" wire:change="validateEmail('create')"/>
                </div>
                <x-input-error :for="'email'"/>

                <div class="mt-4">
                    <x-label for="semester" value="Semestre"/>
                    <select id="semester" wire:model="semester" class="w-full rounded border-gray-300">
                        <option value="" disabled selected>Selecione o semestre</option>
                        @for($i=1;$i<=10;$i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <x-input-error :for="'semester'"/>

                <div class="mt-4">
                    <x-label for="group_id" value="Grupo"/>
                    <x-input id="group_id" class="block mt-1 w-full" type="text" wire:model="group_id"/>
                </div>
                <x-input-error :for="'group_id'"/>

                <div class="mt-4">
                    <x-label for="course_id" value="Curso"/>
                    <x-input id="course_id" class="w-full" type="text" wire:model="course_id"/>
                </div>
                <x-input-error :for="'course_id'"/>
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

                <div>
                    <x-label for="ra" value="RA"/>
                    <x-input id="ra" class="w-full" type="number" wire:model.lazy="ra" onkeydown="return ['e','E','+','-'].indexOf(event.key) === -1" disabled readonly/>
                </div>
                <x-input-error :for="'ra'"/>

                <div class="mt-4">
                    <x-label for="name" value="Nome"/>
                    <x-input id="name" class="w-full" type="text" wire:model="name"/>
                </div>
                <x-input-error :for="'name'"/>

                <div class="mt-4">
                    <x-label for="email" value="E-mail"/>
                    <x-input id="email" class="w-full" type="email" wire:model.lazy="email" wire:keydown="resetError('email')" wire:change="validateEmail('update')"/>
                </div>
                <x-input-error :for="'email'"/>

                <div class="mt-4">
                    <x-label for="semester" value="Semestre"/>
                    <select id="semester" wire:model="semester" class="w-full rounded border-gray-300">
                        <option value="" disabled selected>Selecione o semestre</option>
                        @for($i=1;$i<=10;$i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <x-input-error :for="'semester'"/>

                <div class="mt-4">
                    <x-label for="group_id" value="Grupo"/>
                    <x-input id="group_id" class="block mt-1 w-full" type="text" wire:model="group_id"/>
                </div>
                <x-input-error :for="'group_id'"/>

                <div class="mt-4">
                    <x-label for="course_id" value="Curso"/>
                    <x-input id="course_id" class="w-full" type="text" wire:model="course_id"/>
                </div>
                <x-input-error :for="'course_id'"/>
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

    @if($showInactivationConfirmation)
        <x-confirmation-modal wire:model="showInactivationConfirmation" :maxWidth="'sm'">
            <x-slot name="title">
            </x-slot>
            <x-slot name="content">
                Tem certeza que deseja inativar o aluno?
            </x-slot>
            <x-slot name="footer" >
                <x-danger-button >
                    Inativar
                </x-danger-button>
                <x-secondary-button wire:click="closeModal('inactivation')" class="ms-4">
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
                    <x-button wire:click="openModal('update',{{ $student->ra }})" class="min-w-[98px] ">
                        Alterar
                    </x-button>
                    <x-danger-button type="button" wire:click="openModal('inactivation')">
                        Inativar
                    </x-danger-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="p-2 flex justify-center mt-2 mb-4">
        {{ $students->links() }}
    </div>
</div>

