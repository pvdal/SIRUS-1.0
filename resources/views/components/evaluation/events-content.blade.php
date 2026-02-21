<div>
    <script>
        window.userPermissions = {
            canManageEvents: @json(auth()->user()?->can('manage-events')),
        };
    </script>
    {{-- Coordenador --}}
    @can('manage-events')
        <x-custom-modal x-model="showModal" maxWidth="3xl" :headerActions="true">
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
        <x-custom-modal x-model="showModal" maxWidth="3xl" :headerActions="true">
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
            <div class="flex justify-center items-center border-b border-gray-600 dark:border-gray-900/60 pb-5 p-4 transition duration-150 ease-in-out">
                <h1 class="ms-10 xs:ms-0 text-center text-gray-100 uppercase text-base xs:text-lg md:text-2xl lg:text-3xl transition duration-150 ease-in-out">
                    AGENDA DE AVALIAÇÃO DO SIMBAJU
                </h1>
            </div>
        </div>
        <div class="flex flex-col items-start justify-center bg-gray-50 dark:bg-gray-700/50 transition ease-in-out">
            <div class="w-full px-4 py-3 pb-2 dark:bg-gray-900/40 transition ease-in-out">
                <button
                    x-on:click="
                    $el.blur();
                    filters = !filters;
                "
                    class="flex items-center rounded-md px-2 py-1 gap-2 text-gray-800 dark:text-gray-300 border border-gray-300 dark:border-gray-800 shadow transition"
                    :class="{
                        'bg-white dark:bg-gray-700/60 hover:bg-gray-200/50 dark:hover:bg-gray-700/80 text-gray-800': !filters,
                        'bg-primary-blue text-gray-100': filters,
                    }"
                >
                    <x-lucide-sliders-horizontal class="w-4 h-4"/>
                    <span class="text-sm">Filtros</span>
                </button>
            </div>
            {{-- Filtros | animação de loading | calendário --}}
            <div class="relative">
                <div x-show="filters" class="bg-red-500 flex flex-wrap gap-4 justify-center sm:justify-start px-4 py-2 pb-3 w-full dark:bg-gray-900/40 transition ease-in-out">
                    <div class="flex flex-col max-w-[180px] xs:max-w-full xs:flex-1 xs:min-w-[170px] mb-2">
                        <x-label for="search" class="uppercase text-xs font-light mb-2">Buscar</x-label>
                        <div class="relative">
                            <x-input
                                id="search"
                                type="text"
                                x-model="searchTerm"
                                @keydown.enter="loadEvents()"
                                class="px-4 w-full"
                                placeholder="Buscar eventos..."
                            />
                            <button
                                x-on:click="
                                    $el.blur();
                                    loadEvents();
                                "
                                class="hidden lg:block absolute p-[0.65em] hover:bg-gray-100 dark:hover:bg-gray-700 rounded-md right-[0.15em] top-[0.15em]"
                            >
                                <x-lucide-search class="w-4 h-4 text-gray-800 dark:text-gray-300 transition"/>
                            </button>
                        </div>
                    </div>
                    <div class="flex flex-col w-[180px] md:w-[200px]">
                        <x-legend class="uppercase text-xs font-light mb-2">Curso</x-legend>
                        <div id="courseFilter" class="relative block w-full">
                            <button @click="courseFilter.drop = !courseFilter.drop"
                                    class="flex justify-between items-center w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                               text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                               focus:border-secondary-blue cursor-pointer transition"
                                    x-bind:disabled="loading"
                                    :title="courseFilter.name || 'Selecione um curso'">
                                <span class="truncate" x-text="courseFilter.name || 'Selecione um curso'"></span>
                                <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                            </button>

                            <ul x-show="courseFilter.drop"
                                @click.outside="courseFilter.drop = false"
                                class="absolute w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">
                                <hr />
                                <template x-if="courses.length == 0">
                                    <li class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 break-words rounded-sm transition duration-150 ease-in-out">
                                        Não há cursos cadastrados ainda!
                                    </li>
                                </template>

                                <li @click="courseFilter.id = ''; courseFilter.name = 'Todos os cursos'; courseFilter.drop = false; loadEvents()"
                                    class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800/70 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                    x-show="courses.length > 0"
                                >
                                    Todos os cursos
                                </li>
                                <template x-for="course in courses" :key="course.id">
                                    <li @click="courseFilter.id = course.id; courseFilter.name = course.name; courseFilter.drop = false; loadEvents()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800/70 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                        x-text="course.name">
                                    </li>
                                </template>
                                <hr />
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col w-[180px] md:w-[200px]">
                        <x-legend class="uppercase text-xs font-light mb-2">projeto</x-legend>
                        <div id="projectFilter" class="relative block w-full">
                            <button @click="projectFilter.drop = !projectFilter.drop"
                                    class="flex justify-between items-center w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                               text-left px-4 py-2.5 mb-2 text-sm text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                               focus:border-secondary-blue cursor-pointer transition"
                                    x-bind:disabled="loading"
                                    :title="projectFilter.name || 'Selecione um curso'">
                                <span class="truncate" x-text="projectFilter.name || 'Selecione um projeto'"></span>
                                <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                            </button>

                            <ul x-show="projectFilter.drop"
                                @click.outside="projectFilter.drop = false"
                                class="absolute w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">
                                <hr />

                                <li @click="projectFilter.id = ''; projectFilter.name = 'Todos os projetos'; projectFilter.drop = false; loadEvents()"
                                    class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800/70 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                >
                                    Todos os projetos
                                </li>
                                <template x-for="project in [1,2,3,4,5,6]" :key="project">
                                    <li @click="projectFilter.id = project; projectFilter.name = 'Projeto ' + project; projectFilter.drop = false; loadEvents()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800/70 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                        x-text="'Projeto ' + project">
                                    </li>
                                </template>
                                <hr />
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col w-[180px] md:w-[200px]">
                        <x-legend class="uppercase text-xs font-light mb-2">Restaurar</x-legend>
                        <button
                            id="clearAction"
                            type="button"
                            x-on:click="
                                $el.blur();
                                clearFields();
                                loadEvents();
                            "
                            class="w-full flex appearance-none border border-gray-300 dark:border-gray-400 rounded-lg
                                px-6 py-2.5 mb-2 text-sm text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-secondary-blue
                                focus:border-secondary-blue cursor-pointer items-center justify-between gap-2 transition duration-150 ease-in-out"

                            :title="'Limpar filtros'"
                        >
                            Limpar filtros
                            <x-lucide-trash-2 class="shrink-0 w-4 h-4 text-gray-500 dark:text-gray-200 transition duration-150 ease-in-out"/>
                        </button>
                    </div>
                </div>

                <!-- Barra superior -->
                <div x-show="loadingData"
                     x-transition.opacity
                     class="absolute top-0 left-0 w-full h-1 overflow-hidden z-50">
                    <div class="h-full bg-secondary-blue animate-progress"></div>
                </div>

                <!-- Overlay leve -->
                <div x-show="loadingData"
                     x-transition.opacity
                     class="absolute w-full inset-0 z-40 bg-white/40 dark:bg-gray-900/40">
                </div>

                <style>
                    @keyframes progress {
                        0%   { transform: translateX(-100%); width: 100%; }
                        50%  { transform: translateX(0%); width: 60%; }
                        100% { transform: translateX(100%); width: 100%; }
                    }

                    .animate-progress {
                        animation: progress 1.2s ease-in-out infinite;
                    }
                </style>

                <div id="calendar" class="p-4 w-full bg-transparent text-gray-900 dark:bg-gray-900/40 dark:text-gray-300 transition duration-150 ease-in-out">
                    {{-- conteúdo do calendário --}}
                </div>
            </div>
        </div>
    </div>
</div>

