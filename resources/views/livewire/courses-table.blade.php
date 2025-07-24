<div>
    <x-actions-table-bar
        :primaryAction="['label' => 'Cadastrar Curso', 'method' => 'openModal', 'param' => 'create']"
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
                    Cadastrar Curso
                </x-slot>
                <x-slot name="content">
                    <x-banner/>
                    <div>
                        <div class="mt-4">
                            <x-label for="name" value="Nome do Curso" />
                            <x-input id="name" type="text" class="w-full" placeholder="Nome do curso" wire:model.lazy="name" wire:input="resetError('name')" />
                            <x-input-error :for="'name'" />
                        </div>

                        <div class="mt-4">
                            <x-label for="shift" value="Turno" />
                            <select id="shift" class="w-full rounded border-gray-300" wire:model.lazy="shift" wire:change="resetError('shift')">
                                <option value="" disabled selected>Selecione o turno</option>
                                <option value="Manhã">Matutino</option>
                                <option value="Tarde">Vespertino</option>
                                <option value="Noite">Noturno</option>
                            </select>
                            <x-input-error :for="'shift'" />
                        </div>

                        <div class="mt-4">
                            <x-label for="coordinator_cpf" value="CPF do Coordenador (opcional)" />
                            <x-input id="coordinator_cpf" type="text" class="w-full" placeholder="CPF do coordenador" wire:model.lazy="coordinator_cpf" wire:input="resetError('coordinator_cpf')" />
                            <x-input-error :for="'coordinator_cpf'" />
                        </div>
                    </div>
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
                    Atualizar Curso
                </x-slot>
                <x-slot name="content">
                    <x-banner/>
                    <div>
                        <div class="mt-4">
                            <x-label for="name" value="Nome do Curso" />
                            <x-input id="name" type="text" class="w-full" placeholder="Nome do curso" wire:model.lazy="name" wire:input="resetError('name')" />
                            <x-input-error :for="'name'" />
                        </div>

                        <div class="mt-4">
                            <x-label for="shift" value="Turno" />
                            <select id="shift" class="w-full rounded border-gray-300" wire:model.lazy="shift" wire:change="resetError('shift')">
                                <option value="" disabled selected>Selecione o turno</option>
                                <option value="Manhã">Matutino</option>
                                <option value="Tarde">Vespertino</option>
                                <option value="Noite">Noturno</option>
                            </select>
                            <x-input-error :for="'shift'" />
                        </div>

                        <div class="mt-4">
                            <x-label for="coordinator_cpf" value="CPF do Coordenador (opcional)" />
                            <x-input id="coordinator_cpf" type="text" class="w-full" placeholder="CPF do coordenador" wire:model.lazy="coordinator_cpf" wire:input="resetError('coordinator_cpf')" />
                            <x-input-error :for="'coordinator_cpf'" />
                        </div>
                    </div>
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
                <x-slot name="content">
                    {{ $warningContent }}
                </x-slot>
                <x-slot name="footer">
                    @if($warningType === 'Confirmação')
                        <x-danger-button id="Inactivate" type="button" wire:click="inactivate">
                            Inativar
                        </x-danger-button>
                    @endif
                    <x-secondary-button id="closeModalInactivation" type="button" wire:click="closeModal('inactivation')" class="ms-4">
                        Voltar
                    </x-secondary-button>
                </x-slot>
            </x-confirmation-modal>
        @endif


        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-5">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">ID</th>
                    <th class="px-4 py-2 text-center text-gray-700">Nome</th>
                    <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Turno</th>
                    <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">Coordenador</th>
                    <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Estado</th>
                    <th class="px-4 py-2 text-center text-gray-700">Ações</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach($courses as $course)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $course->id}}</td>
                        <td class="px-4 py-2 border text-center border-gray-300">{{ $course['name'] }}</td>
                        <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $course['shift'] }}</td>
                        <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $course['coordinator_cpf'] }}</td>
                        <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $course['state'] == 1 ? 'Ativo' : 'inativo'}}</td>
                        <td class="px-4 py-2 border text-center border-gray-300">
                            <x-button
                                id="openModalUpdate"
                                type="button"
                                wire:click="openModal('update',{{ $course->id }})"
                                class="min-w-[98px]"
                                x-on:click="$el.blur()"
                            >
                                Alterar
                            </x-button>
                            @if($course['state'] == 1)
                                <x-danger-button
                                    id="openModalInactivation"
                                    type="button"
                                    wire:click="openModal('inactivation',{{ $course->id }})"
                                    class="min-w-[98px]"
                                    x-on:click="$el.blur()"
                                >
                                    Inativar
                                </x-danger-button>
                            @else
                                <x-danger-button
                                    id="activate"
                                    class="min-w-[98px]"
                                    type="button"
                                    wire:click="activate({{ $course->id }})"
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

</div>
