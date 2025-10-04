<div>
    <script>
        window.userPermissions = {
            canManageEvents: @json(auth()->user()?->can('manage-events')),
        };
    </script>
    {{-- Coordenador --}}
    @can('manage-events')
        <x-custom-modal x-model="showModal" :titleClass="'flex flex-row justify-between items-center'">
            <x-slot name="title">
                <div x-show="edit">
                    Atualizar a data da banca
                </div>
                <div x-show="!edit && !showCreateModal">
                    Avaliar o grupo
                </div>
                <div x-show="showCreateModal">
                    Agendar uma nova banca
                </div>
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
                        <button
                            x-on:click="
                                saveEvent;
                                $el.blur();
                            "
                            class="
                                'class' => 'inline-flex items-center justify-center px-4 py-2 bg-secondary-blue border
                                 border-gray-300 rounded-md font-semibold text-xs text-white uppercase tracking-widest
                                 shadow-sm hover:opacity-90 focus:outline-none focus:ring-2 focus:ring-secondary-blue
                                 focus:ring-offset-2 disabled:opacity-50 transition ease-in-out duration-150'
                            "
                            :disabled="committees.length < 1"
                            :title="committees.length < 1 ? 'Não é possível agendar nova data de banca.' : ''"
                        >
                            Salvar
                        </button>
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
                        <template x-if="belongsTo">
                            <x-secondary-button>Avaliar</x-secondary-button>
                        </template>
                        <template x-if="!belongsTo">
                            <x-secondary-button>Avaliação</x-secondary-button>
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
    @if(!auth()->user()->canManageEvents())
        <x-custom-modal x-model="showModal">
            <x-slot name="title">
                @if(auth()->user()->canEvaluate())
                    Avaliar o grupo
                @else
                    Vizualizar a avaliação da banca
                @endif
            </x-slot>
            <x-slot name="content">
                {{-- Banner de mensagem --}}
                <x-custom-banner/>

                <x-form-fields.event/>
            </x-slot>

            <x-slot name="footer">
                @if(auth()->user()->canEvaluate())
                    <x-secondary-button>Avaliar</x-secondary-button>
                    <x-danger-button
                        x-on:click="
                                $el.blur();
                                showEvaluationModal = false;
                                showModal = false;
                            "
                    >Fechar</x-danger-button>
                @else
                    <x-secondary-button>Avaliação</x-secondary-button>
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
    @endif

    <div class="p-0 border-4 rounded overflow-hidden border-strong-blue">
        <div class="bg-primary-blue bg-blend-darken">
            <h1 class="text-center text-white border-b border-gray-600 pb-5 p-4 text-base sm:text-lg md:text-2xl lg:text-3xl">
                AGENDA DE AVALIAÇÃO DO SIMBAJU
            </h1>
        </div>
        <div class="flex justify-center">
            <div id="calendar" class="p-4 w-full max-w-4xl">
                <!-- conteúdo do calendário -->
            </div>
        </div>
    </div>
</div>

