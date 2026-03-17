<x-app-layout>
    <x-slot name="title">
        Alunos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Alunos cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/studentsData.js--}}
        <div x-data="studentsData()"
             x-init='init(@json($students), @json($groups), @json($courses), {{ $page }}, {{ $totalPages }})'>{{-- com paginação backend: , {{ $current_page }}, {{ $last_page }} --}}
            <x-nav-users-table> {{-- Navegação das tabelas de usuário --}}
                {{-- Menu utilitário das tabelas --}}
                {{-- , 'additional' => 'edit = false;' --}}
                <template x-if="students">
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar Aluno', 'method' => 'showCreateModal']"
                        :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar alunos...'"
                        :searchWidth="'xs:w-4/12'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadStudents()'"
                        :class="'lg:justify-start'"
                    >
                        {{-- Filtros adicionais --}}
                        <x-slot name="filters">
                            {{-- Filtro por curso --}}
                            <div id="courseFilter" class="relative block max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2">
                                <button @click="courseFilter.drop = !courseFilter.drop"
                                        class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                           text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                           focus:border-secondary-blue cursor-pointer transition"
                                        x-bind:disabled="loading"
                                        :title="courseFilter.name || 'Selecione um curso'">
                                    <span class="truncate" x-text="courseFilter.name || 'Selecione um curso'"></span>
                                    <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                                </button>

                                <ul x-show="courseFilter.drop"
                                    @click.outside="courseFilter.drop = false"
                                    class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">
                                    <hr />
                                    <template x-if="courses.length == 0">
                                        <li class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 break-words rounded-sm transition duration-150 ease-in-out">
                                            Não há cursos cadastrados ainda!
                                        </li>
                                    </template>

                                    <li @click="courseFilter.id = ''; courseFilter.name = 'Todos os cursos'; courseFilter.drop = false; loadStudents()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                        x-show="courses.length > 0"
                                    >
                                        Todos os cursos
                                    </li>
                                    <template x-for="course in courses" :key="course.id">
                                        <li @click="courseFilter.id = course.id; courseFilter.name = course.name; courseFilter.drop = false; loadStudents()"
                                            class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                            x-text="course.name">
                                        </li>
                                    </template>
                                    <hr />
                                </ul>
                            </div>

                            {{-- Filtro por grupo --}}
                            <div id="groupFilter" class="relative block max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2">
                                <button @click="groupFilter.drop = !groupFilter.drop"
                                        class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                           text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                           focus:border-secondary-blue cursor-pointer transition"
                                        x-bind:disabled="loading"
                                        :title="groupFilter.theme || 'Selecione um grupo'">
                                    <span class="truncate" x-text="groupFilter.theme || 'Selecione um grupo'"></span>
                                    <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                                </button>

                                <ul x-show="groupFilter.drop"
                                    @click.outside="groupFilter.drop = false"
                                    class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom pb-5 px-1 transition duration-150 ease-in-out">
                                    <li class="flex items-center m-1">
                                        <x-lucide-search class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition"/>
                                        <input
                                            type="search"
                                            class="bg-transparent w-full py-1 px-2 border-transparent focus:outline-none focus:ring-0 focus:border-transparent
                                                text-gray-700 dark:text-gray-100"
                                            placeholder="Buscar grupo..."
                                            x-model="groupFilter.search"
                                        />
                                    </li>

                                    <hr />
                                    <li @click="groupFilter.id = ''; groupFilter.theme = 'Todos os grupos'; groupFilter.drop = false; loadStudents()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                    >
                                        Todos os grupos
                                    </li>
                                    <template x-if="searching">
                                        <li class="px-4 py-1 text-sm text-gray-500 break-words rounded-sm transition duration-150 ease-in-out">Buscando...</li>
                                    </template>
                                    <template x-if="!groups.length && groupFilter.search && !searching && showNoGroupsMsg">
                                        <li class="px-4 py-1 text-sm text-gray-500 break-words rounded-sm transition duration-150 ease-in-out">Nenhum grupo encontrado.</li>
                                    </template>

                                    <div x-show="groups.length > 0">
                                        <template x-for="group in groups" :key="group.id">
                                            <li @click="groupFilter.id = group.id; groupFilter.theme = group.theme; groupFilter.drop = false; loadStudents()"
                                                class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                                x-text="group.theme">
                                            </li>
                                        </template>
                                    </div>
                                    <hr />
                                </ul>
                            </div>

                            {{--Ações Excel--}}
                            <div class="relative block max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2" x-data="{ openExcel: false }">
                                <button @click="openExcel = !openExcel"
                                        class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                           text-left px-4 py-2.5 mb-2 text-sm text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                           focus:border-secondary-blue cursor-pointer transition"
                                        type="button">
                                    <div class="flex items-center truncate">
                                        <x-lucide-file-spreadsheet class="w-4 h-4 me-2 text-green-600" />
                                        <span>Opções Excel</span>
                                    </div>
                                    <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                                </button>

                                <ul x-show="openExcel"
                                    @click.outside="openExcel = false"
                                    x-cloak
                                    class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">

                                    <hr/>

                                    <li @click="showImportModal = true; openExcel = false"
                                        class="flex items-center w-full px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out">
                                        <x-lucide-upload class="w-4 h-4 me-2 text-blue-500" />
                                        Importar Alunos
                                    </li>

                                    <li class="p-0">
                                        <a :href="'{{ route('users.students-generate-file') }}?' +
                                           'searchTerm=' + searchTerm +
                                           '&courseId=' + courseFilter.id +
                                           '&groupId=' + groupFilter.id +
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
                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <template x-if="students">
                    <x-management.students-content/>
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
                        :load-function="'loadStudents'"
                    />
                </template>
            </x-nav-users-table>
            {{--Modal importação--}}
            <x-import-modal
                title="Importar Alunos"
                :downloadRoute="route('users.students.download-template')"
                :importRoute="route('users.students.import')"
                loadFunction="loadStudents()"
            />
        </div>
    </x-main-content>
</x-app-layout>
