<x-app-layout>
    <x-slot name="title">
        Grupos
    </x-slot>

    <x-slot name="header">
        <h2 id="page-title" x-text="window.headerTitle ?? ''" class="font-semibold text-xl leading-tight">Grupos cadastrados</h2>
        <div x-data="{ showPaper: false }"
             x-init="document.getElementById('page-title')?.remove()"
             x-on:toggle-paper.window="showPaper = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('toggle-groups'); $dispatch('toggle-nav-bar', true);">Visualizar Grupos</x-button>
            </div>
            <h2 x-show="!showPaper" x-cloak class="font-semibold text-xl leading-tight">Grupos cadastrados</h2>
        </div>
    </x-slot>

    {{-- Chamada da função alpine -> recources/js/components/management/groupsData.js--}}
    <div
        x-data="groupsData()"
        x-on:toggle-groups.window="
                showGroupCards = true;
                showGroupPaper = false;
                paperUrl = '';
                $dispatch('toggle-paper', false);
        "
        x-init='init(@json($groups), @json($courses), {{ $page }}, {{ $totalPages }})'
    >
        {{-- Div exibida enquanto os dados não chegam no front --}}
        {{-- Estou chamando fora devido a necessidade de remover o modal da página do DOM para exibir o PDF com scroll --}}
        {{-- Grupos cadastrados --}}
        <div x-show="showGroupCards">
            <x-main-content>
                {{-- Menu utilitário das tabelas --}}
                <template x-if="groups">
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar grupo', 'method' => 'showCreateModal']"
                        :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar grupos...'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadGroups()'"
                        :class="'md:justify-start'"
                    />
                </template>
                {{-- Componente com o conteúdo --}}
                <template x-if="groups">
                    <x-management.groups-content
                        :courses="$courses"
                    />
                </template>
                {{-- Div exibida enquanto os dados não chegam no front --}}
                <x-feedback.loading/>
                {{-- Div exibida caso não haja registros no banco --}}
                <template x-if="isEmpty && !loading">
                    <x-feedback.empty-state/>
                </template>
                {{-- Paginação --}}
                <template x-if="page && !loading">
                    <x-feedback.pagination
                        :page-var="'page'"
                        :total-pages="'totalPages'"
                        :load-function="'loadGroups'"
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
