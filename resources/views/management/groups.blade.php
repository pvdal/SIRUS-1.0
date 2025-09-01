<x-app-layout>
    <x-slot name="title">
        Grupos
    </x-slot>

    <x-slot name="header">
        <div x-data="{ showPaper: false }"
             x-on:toggle-paper.window="showPaper = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('toggle-groups')">Visualizar Grupos</x-button>
            </div>
            <h2 x-show="!showPaper" x-cloak class="font-semibold text-xl">Grupos cadastrados</h2>
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
        x-init='init(@json($groups),@json($students),{{ $current_page }}, {{ $last_page }})'
    >
        {{-- Grupos cadastrados --}}
        <template x-if="showGroupCards">
            <x-main-content>
                {{-- Menu utilitário das tabelas --}}
                <x-actions-table-bar
                    :primary-action="['label' => 'Cadastrar grupo', 'method' => 'showCreateModal']"
                    :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                    :search-model="'searchTerm'"
                    :status-filter="'statusFilter'"
                    :register-period="'registerPeriod'"
                    :load-function="'loadGroups()'"
                    :class="'md:justify-start'"
                />
                {{-- Componente com o conteúdo --}}
                <x-management.groups-content/>
                {{-- Paginação --}}
                <x-management.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadGroups'"
                />
            </x-main-content>
        </template>
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
