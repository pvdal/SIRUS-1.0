<div>
    <script>
        window.userPermissions = {
            canManageEvents: @json(auth()->user()?->can('manage-events')),
        };
    </script>
    {{-- Coordenador --}}
    @can('manage-events')
        <x-custom-modal x-model="showModal" :headerActions="true">
            <x-slot name="title">
                <div class="flex flex-wrap items-center justify-start gap-3">
                    <h1 class="me-auto text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <div x-show="edit">
                            Atualizar a data da banca
                        </div>
                        <div x-show="!edit && !showCreateModal">
                            Avaliar o grupo
                        </div>
                        <div x-show="showCreateModal">
                            Agendar uma nova banca
                        </div>
                    </h1>

                    <div x-show="showEvaluationModal || edit">
                        <x-secondary-button
                            x-on:click="
                                $el.blur();
                                edit = !edit;
                            "
                        >
                            <div x-show="edit" class="flex flex-row gap-2">
                                Avaliar
                                <x-lucide-clipboard-check class="text-white h-4 w-4"/>
                            </div>
                            <div x-show="!edit" class="flex flex-row gap-2">
                                Editar
                                <x-lucide-pencil class="text-white h-4 w-4"/>
                            </div>
                        </x-secondary-button>
                    </div>
                </div>

            </x-slot>

            <x-slot name="content">
                {{-- Banner de mensagem --}}
                <x-custom-banner/>

                <template x-if="showCreateModal && !edit">
                    <x-form-fields.event type="create" />
                </template>
                <template x-if="showEvaluationModal || edit">
                    <x-form-fields.event />
                </template>
            </x-slot>

            <x-slot name="footer">
                <template x-if="showCreateModal || edit">
                    <div>
                        <x-secondary-button
                            x-on:click="
                                saveEvent();
                                $el.blur();
                            "

                            x-bind:disabled="events.length < 1 && !edit"
                            x-bind:title="events.length < 1 && !edit ? 'Não é possível agendar nova data de banca.' : ''"
                        >
                            Salvar
                        </x-secondary-button>
                        <x-danger-button
                            x-on:click="
                                    $el.blur();
                                    showCreateModal = false;
                                    showModal = false;
                                "
                        >Fechar</x-danger-button>
                    </div>
                </template>
                <template x-if="showEvaluationModal && !edit">
                    <div>
                        <template x-if="belongsTo && !evaluatedByUser">
                            <x-secondary-button x-show="belongsTo" @click="openEvaluationForm()">Avaliar</x-secondary-button>
                        </template>
                        <template x-if="!belongsTo || evaluatedByUser">
                            <x-secondary-button @click="openEvaluationForm()">Avaliação</x-secondary-button>
                        </template>
                        <x-danger-button
                            x-on:click="
                                $el.blur();
                                showEvaluationModal = false;
                                showModal = false;
                            "
                        >Fechar</x-danger-button>
                    </div>
                </template>
            </x-slot>
        </x-custom-modal>
    @endcan
    {{-- Professor e aluno --}}
    @cannot('manage-events')
        <x-custom-modal x-model="showModal" :headerActions="true">
            <x-slot name="title">
                <h1 class="me-auto text-lg font-semibold text-gray-700 dark:text-gray-200">
                    @if(auth()->user()->canEvaluate())
                        Avaliar o grupo
                    @else
                        Vizualizar a avaliação da banca
                    @endif
                </h1>
            </x-slot>
            <x-slot name="content">
                {{-- Banner de mensagem --}}
                <x-custom-banner/>
                {{-- Formulário --}}
                <x-form-fields.event/>
            </x-slot>

            <x-slot name="footer">
                @if(auth()->user()->canEvaluate())
                    <template x-if="belongsTo && !evaluatedByUser">
                        <x-secondary-button @click="openEvaluationForm()">Avaliar</x-secondary-button>
                    </template>
                    <template x-if="!belongsTo || evaluatedByUser">
                        <x-secondary-button @click="openEvaluationForm()">Avaliação</x-secondary-button>
                    </template>
                    <x-danger-button
                        x-on:click="
                            $el.blur();
                            showEvaluationModal = false;
                            showModal = false;
                        "
                    >Fechar</x-danger-button>
                @else
                    <template x-if="belongsTo">
                        <x-secondary-button x-on:click="$el.blur(); openEvaluationForm();">Avaliação</x-secondary-button>
                    </template>
                    <x-danger-button
                        x-on:click="
                                $el.blur();
                                showEvaluationModal = false;
                                showModal = false;
                            "
                    >Fechar</x-danger-button>
                @endif
            </x-slot>
        </x-custom-modal>
    @endcannot

    <div class="p-0 border-2 rounded-lg overflow-hidden border-strong-blue">
        <div class="bg-primary-blue bg-blend-darken transition duration-150 ease-in-out">
            <h1 class="text-center text-gray-100 uppercase border-b border-gray-600 dark:border-gray-900 pb-5 p-4 text-base sm:text-lg md:text-2xl lg:text-3xl transition duration-150 ease-in-out">
                AGENDA DE AVALIAÇÃO DO SIMBAJU
            </h1>
        </div>
        <div class="flex justify-center bg-white dark:bg-gray-800">
            <div id="calendar" class="p-4 w-full max-w-4xl bg-white text-gray-900 dark:bg-gray-800 dark:text-gray-300 transition duration-150 ease-in-out">
                {{-- conteúdo do calendário --}}
            </div>
        </div>
    </div>
</div>

