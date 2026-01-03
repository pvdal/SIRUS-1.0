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
                                    class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">
                                    <hr />
                                    <template x-if="groups.length == 0">
                                            <li class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 break-words rounded-sm transition duration-150 ease-in-out">
                                            Não há grupos cadastrados ainda!
                                        </li>
                                    </template>

                                    <li @click="groupFilter.id = ''; groupFilter.theme = 'Todos os grupos'; groupFilter.drop = false; loadStudents()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                        x-show="groups.length > 0"
                                    >
                                        Todos os grupos
                                    </li>
                                    <template x-for="group in groups" :key="group.id">
                                        <li @click="groupFilter.id = group.id; groupFilter.theme = group.theme; groupFilter.drop = false; loadStudents()"
                                            class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                            x-text="group.theme">
                                        </li>
                                    </template>
                                    <hr />
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
        </div>
    </x-main-content>
</x-app-layout>
