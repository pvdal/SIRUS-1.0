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
                {{--
                <nav class="bg-white rounded-lg border-b border-gray-100 dark:bg-gray-900 dark:border-gray-700 transition duration-150 ease-in-out">
                    <!-- Menu padrão (desktop e acima de 300px) -->
                    <div class="max-w-[2100px] mx-auto hidden xxs:block border-b border-gray-100 dark:border-gray-700 transition duration-150 ease-in-out">
                        <div class="flex justify-between h-16 w-full">
                            <div class="flex">
                                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                                    <button
                                        type="button"
                                        x-on:click="
                                    $el.blur();
                                    showDirectories = false;
                                "
                                        class="inline-flex items-center px-1 pt-1 text-gray-500 border-b-2 border-transparent p-0 m-0 text-sm font-medium leading-5 transition duration-150 ease-in-out"
                                        :class="{
                                        'border-secondary-blue text-gray-900 dark:text-gray-200 focus:outline-none': showDirectories === false,
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-500 dark:hover:text-gray-200 dark:hover:border-gray-600': showDirectories === true
                                    }"
                                    >
                                        Tabela
                                    </button>
                                </div>
                                <div class="hidden space-x-8 sm:-my-px xxs:ms-5 xs:ms-10 xxs:flex">
                                    <button
                                        type="button"
                                        x-on:click="
                                    $el.blur();
                                    showDirectories = true;
                                "
                                        class="inline-flex items-center px-1 pt-1 text-gray-500 border-b-2 border-transparent p-0 m-0 text-sm font-medium leading-5 transition duration-150 ease-in-out"
                                        :class="{
                                        'border-secondary-blue text-gray-900 dark:text-gray-200 focus:outline-none': showDirectories === true,
                                        'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 dark:text-gray-500 dark:hover:text-gray-200 dark:hover:border-gray-600': showDirectories === false,
                                    }"
                                    >
                                        Explorador
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </nav>
                --}}
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
                                x-text="'Exibindo: ' + papers.length"
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
                    />
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
