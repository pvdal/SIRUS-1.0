<x-app-layout>
    <x-slot name="title">
        Professores
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Professores cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/professorsData.js--}}
        <div x-data="professorsData()"
             x-init='init(@json($professors), {{ $page}}, {{ $totalPages}})'>
            <x-nav-users-table> {{-- Navegação das tabelas de usuário --}}
                {{-- Menu utilitário das tabelas --}}
                <template x-if="professors">
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar Professor', 'method' => 'showCreateModal']"
                        :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields', 'param' => 'filters']"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar professores...'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadProfessors()'"
                        :class="'md:justify-start'"
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
                                    x-cloak
                                    class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">

                                    <hr/>
                                    <li @click="showImportModal = true; openExcel = false"
                                        class="flex items-center w-full px-3 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out">
                                        <x-lucide-upload class="w-4 h-4 me-2 text-blue-500" />
                                        <span>Importar Professores</span>
                                    </li>
                                    <li class="p-0">
                                        <a :href="'{{ route('users.professors-generate-file') }}?' +
                                           'searchTerm=' + searchTerm +
                                           '&status=' + statusFilter.value +
                                           '&period=' + registerPeriod.value"
                                           @click="openExcel = false"
                                           class="flex items-center w-full px-3 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out">
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
                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <template x-if="professors">
                    <x-management.professors-content/>
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
                        :load-function="'loadProfessors'"
                    />
                </template>
            </x-nav-users-table>

            {{--            Modal importação--}}
            <x-import-modal
                title="Importar Professores"
                :downloadRoute="route('users.professors.download-template')"
                :importRoute="route('users.professors.import')"
                loadFunction="loadProfessors()"
            />
        </div>
    </x-main-content>
</x-app-layout>
