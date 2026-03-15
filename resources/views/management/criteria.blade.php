<x-app-layout>
    <x-slot name="title">
        Critérios
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Critérios cadastrados') }}
        </h2>
    </x-slot>

        <x-main-content>
            <div x-data="{ ...criteriaData(),showImportModal:false }"
                 x-init='init(@json($criteria), {{ $page }}, {{ $totalPages }})'>

                <x-nav-evaluation-table>
                    {{-- ... seu conteúdo de tabela, filtros, etc. ... --}}
                    <template x-if="criteria">
                        <x-actions-table-bar
                            :primary-action="['label' => 'Cadastrar Critério', 'method' => 'showCreateModal', 'additional' => 'edit = false;']"
                            :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                            :search-model="'searchTerm'"
                            :search-placeholder="'Buscar critérios...'"
                            :status-filter="'statusFilter'"
                            :register-period="'registerPeriod'"
                            :load-function="'loadCriteria()'"
                            :class="'lg:justify-start'"
                        >
                            <x-slot name="filters">
                                {{--Ações Excel--}}
                                <div class="relative block max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2" x-data="{ openExcel: false }">
                                    <button @click="openExcel = !openExcel"
                                            class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                                        text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 dark:text-gray-200 focus:ring-3 focus:ring-secondary-blue
                                                        focus:border-secondary-blue cursor-pointer transition duration-150 ease-in-out"
                                            type="button">

                                        <x-lucide-file-spreadsheet class="w-4 h-4 me-2 text-green-600" />
                                        <span class="truncate" x-text="'Opções Excel'"></span>
                                        <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                                    </button>

                                    <ul x-show="openExcel"
                                        @click.outside="openExcel = false"
                                        class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">

                                        <hr/>

                                        <li @click="showImportModal = true; openExcel = false"
                                            class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out">
                                            <x-lucide-upload class="w-4 h-4 me-2 text-blue-500" />
                                            Importar Criterios
                                        </li>

                                        <li class="p-0">
                                            <a :href="'{{ route('evaluation.criteria-generate-file') }}?' +
                                                   'searchTerm=' + searchTerm +
                                                   '&status=' + statusFilter.value +
                                                   '&period=' + registerPeriod.value"
                                               @click="openExcel = false"
                                               class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out">
                                                <x-lucide-download class="w-4 h-4 me-2 text-green-500" />
                                                Exportar Lista
                                            </a>
                                        </li>

                                        <hr/>
                                    </ul>
                                </div>
                            </x-slot>
                        </x-actions-table-bar>
                    </template>
                    {{--Conteúdo que mostra os critérios cadastrados--}}
                    <template x-if="criteria">
                        <x-management.criteria-content/>
                    </template>
                    {{-- Div exibida enquanto os dados não chegam no front --}}
                    <x-feedback.loading/>
                    {{-- Div exibida caso não haja registros no banco --}}
                    <template x-if="isEmpty && !loading">
                        <x-feedback.empty-state />
                    </template>
                    {{-- Paginação --}}
                    <template x-if="page && !loading">
                        <x-feedback.pagination
                            :page-var="'page'"
                            :total-pages="'totalPages'"
                            :load-function="'loadCriteria'"
                        />
                    </template>
                </x-nav-evaluation-table>

                {{--            Modal importação--}}
                <x-import-modal
                    title="Importar Critérios"
                    :downloadRoute="route('evaluation.criteria.download-template')"
                    :importRoute="route('evaluation.criteria.import')"
                    loadFunction="loadCriteria()"
                />
            </div>
        </x-main-content>
    {{-- Fechamento do novo menu --}}

</x-app-layout>
