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
            <div x-data="criteriaData()"
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
                <div x-show="showImportModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">
                    <div @click.outside="showImportModal = false" class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl max-w-md w-full">
                        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">Importar Critérios</h2>

                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                            Para importar, utilize nosso modelo padrão para evitar erros de leitura.
                            <a href="{{ route('evaluation.criteria.download-template') }}" class="text-blue-500 font-bold block mt-2 underline">
                                Baixar Modelo Excel
                            </a>
                        </p>

                        <form action="{{ route('evaluation.criteria.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-4">
                                <input type="file" name="file" required class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            </div>

                            <div class="flex justify-end space-x-3">
                                <button type="button" @click="showImportModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">Cancelar</button>
                                <button type="submit" @click="showImportModal = false" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">Iniciar Importação</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </x-main-content>
    {{-- Fechamento do novo menu --}}

</x-app-layout>
