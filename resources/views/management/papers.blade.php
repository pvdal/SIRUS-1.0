<x-app-layout>
    <x-slot name="title">
        Trabalhos
    </x-slot>

    <x-slot name="header">
        <h2 id="page-title" x-text="window.headerTitle ?? ''" class="font-semibold text-xl leading-tight">Trabalhos cadastrados</h2>
        <div x-data="{ showPaper: false }"
             x-init="document.getElementById('page-title')?.remove()"
             x-on:toggle-paper.window="showPaper = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('toggle-groups'); $dispatch('toggle-nav-bar', true);">Visualizar Trabalhos</x-button>
            </div>
            <h2 x-show="!showPaper" x-cloak class="font-semibold text-xl leading-tight">Trabalhos cadastrados</h2>
        </div>
    </x-slot>

    {{-- Chamada da função alpine -> recources/js/components/management/papersData.js--}}
    <div
        x-data="papersData()"
        x-on:toggle-groups.window="
                showGroupCards = true;
                showGroupPaper = false;
                paperUrl = '';
                $dispatch('toggle-paper', false);
        "
        x-init='init(@json($papers), @json($courses), @json($groups),{{ $page }}, {{ $totalPages }}, {{ $totalItems }})'
    >
        {{-- Div exibida enquanto os dados não chegam no front --}}
        {{-- Grupos cadastrados --}}
        <div x-show="showGroupCards">
            {{-- Conteúdo principal --}}
            <x-main-content>
                {{-- Seleção de visualização --}}
                <template x-if="papers && papers.length > 0">
                    <div class="flex items-center max-w-full gap-4 px-2 pt-2">
                        <div class="inline-block bg-gray-100 shadow-inner dark:bg-gray-800 rounded-full me-auto transition duration-150 ease-in-out">
                            <div class="flex justify-between p-1 space-x-2">
                                <button
                                    class="rounded-full px-3 py-1 transition duration-150 ease-in-out"
                                    :class="{
                                        'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-700': showDirectories === true,
                                        'bg-primary-blue': showDirectories === false,
                                    }"
                                    x-on:click="
                                        $el.blur();
                                        showDirectories = false;
                                    "
                                >
                                    <x-lucide-table
                                        class="w-4 h-4 transition duration-150 ease-in-out"
                                        x-bind:class="{
                                            'text-gray-900 dark:text-gray-100': showDirectories === true,
                                            'text-gray-100': showDirectories === false,
                                        }"
                                    />
                                </button>
                                <button
                                    class="rounded-full px-3 py-1 transition duration-150 ease-in-out"
                                    :class="{
                                        'bg-transparent hover:bg-gray-100 dark:hover:bg-gray-700': showDirectories === false,
                                        'bg-primary-blue': showDirectories === true,
                                    }"
                                    x-on:click="
                                        $el.blur();
                                        showDirectories = true;
                                        loadYears();
                                    "
                                >
                                    <x-lucide-folder
                                        class="w-4 h-4 transition duration-150 ease-in-out"
                                        x-bind:class="{
                                            'text-gray-900 dark:text-gray-100': showDirectories === false,
                                            'text-gray-100': showDirectories === true,
                                        }"
                                    />
                                </button>
                            </div>
                        </div>
                        <template x-if="showDirectories">
                            <div class="flex gap-5 me-4">
                            <span
                                class="font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out"
                                x-text="'Carregados: ' + loadedPapers"
                            ></span>
                                <span
                                    class="font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out"
                                    x-text="'Total: ' + totalPapers"
                                ></span>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="papers && !showDirectories">
                    {{-- Menu utilitário das tabelas --}}
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar Trabalhos', 'method' => 'showCreateModal']"
                        :clear-action="['label' => 'Limpar Filtros', 'method' => 'clearFields', 'param' => 'filters' ]"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar trabalhos...'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadPapers()'"
                        :class="'md:justify-start'"
                    >
                        {{-- Filtros adicionais --}}
                        <x-slot name="filters">
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
                                    <li @click="groupFilter.id = ''; groupFilter.theme = 'Todos os grupos'; groupFilter.drop = false; loadPapers()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                    >
                                        Todos os grupos
                                    </li>
                                    <template x-if="searching">
                                        <li class="px-4 py-1 text-sm text-gray-500 break-words rounded-sm transition duration-150 ease-in-out">Buscando...</li>
                                    </template>
                                    <template x-if="!filteredGroups.length && groupFilter.search && !searching && showNoGroupsMsg">
                                        <li class="px-4 py-1 text-sm text-gray-500 break-words rounded-sm transition duration-150 ease-in-out">Nenhum grupo encontrado.</li>
                                    </template>

                                    <div x-show="filteredGroups.length > 0">
                                        <template x-for="group in filteredGroups" :key="group.id">
                                            <li @click="groupFilter.id = group.id; groupFilter.theme = group.theme; groupFilter.drop = false; loadPapers()"
                                                class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                                x-text="group.theme">
                                            </li>
                                        </template>
                                    </div>
                                    <hr />
                                </ul>
                            </div>

                            {{-- Filtro por versão
                            <div id="versionFilter" class="relative block max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2">
                                <button @click="versionFilter.drop = !versionFilter.drop"
                                        class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                           text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                           focus:border-secondary-blue cursor-pointer transition"
                                        x-bind:disabled="loading"
                                        :title="versionFilter.name || 'Selecione uma versão'">
                                    <span class="truncate" x-text="versionFilter.name || 'Selecione uma versão'"></span>
                                    <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
                                </button>

                                <ul x-show="versionFilter.drop"
                                    @click.outside="versionFilter.drop = false"
                                    class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white dark:bg-gray-700 dark:border-gray-900 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom py-5 px-1 transition duration-150 ease-in-out">
                                    <hr />
                                    <li @click="versionFilter.value = ''; versionFilter.name = 'Todos as versões'; versionFilter.drop = false; loadPapers()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                    >
                                        Todos as versões
                                    </li>

                                    <li @click="versionFilter.value = 'evaluation'; versionFilter.name = 'Apenas avaliações'; versionFilter.drop = false; loadPapers()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                    >
                                        Apenas avaliações
                                    </li>

                                    <li @click="versionFilter.value = 'corrected'; versionFilter.name = 'Apenas corrigidos'; versionFilter.drop = false; loadPapers()"
                                        class="px-4 py-1 text-sm text-gray-700 dark:text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-800 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out"
                                    >
                                        Apenas corrigidos
                                    </li>
                                    <hr />
                                </ul>
                            </div>
                            --}}
                        </x-slot>
                    </x-actions-table-bar>
                </template>

                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <template x-if="papers">
                    <x-management.papers-content :courses="$courses"/>
                </template>
                {{-- Div exibida enquanto os dados não chegam no front --}}
                <x-feedback.loading/>
                {{-- Div exibida caso não haja registros no banco --}}
                <template x-if="isEmpty && !loading && !showDirectories">
                    <x-feedback.empty-state />
                </template>
                {{-- Paginação --}}
                <template x-if="page && !loading && !showDirectories">
                    <x-feedback.pagination
                        :page-var="'page'"
                        :total-pages="'totalPages'"
                        :load-function="'loadPapers'"
                    />
                </template>
            </x-main-content>
        </div>
        {{-- Trabalhos cadastrados --}}
        <template x-if="showGroupPaper">
            <div class="relative">
                {{-- Carregando... --}}
                <div
                    x-show="isLoadingPdf"
                    class="absolute inset-0 z-10 flex items-center justify-center bg-white bg-opacity-75"
                >
                    <span class="text-gray-600 text-lg">Carregando PDF...</span>
                </div>
                {{-- Iframe do PDF --}}
                <iframe
                    x-bind:src="paperUrl"
                    class="w-full h-[100vh] border border-gray-300 rounded-md"
                    type="application/pdf"
                    @load="isLoadingPdf = false"
                ></iframe>
            </div>
        </template>
    </div>
</x-app-layout>
