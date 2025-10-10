<x-app-layout>
    <x-slot name="title">
        Bancas
    </x-slot>

    <x-slot name="header">
        <div x-data="{ showPaper: false }"
             x-on:toggle-paper.window="showPaper = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('toggle-groups')">Visualizar Bancas</x-button>
            </div>
            <h2 x-show="!showPaper" x-cloak class="font-semibold text-xl">Bancas cadastradas</h2>
        </div>
    </x-slot>

    {{-- Conteúdo principal --}}
    <div
        x-data="committeesData()"
        x-on:toggle-groups.window="
                showGroupCards = true;
                showGroupPaper = false;
                paperUrl = '';
                $dispatch('toggle-paper', false);
        "
        x-init='init(@json($committees), @json($member_types), @json($groups), @json($academicStaff), {{ $page}}, {{ $totalPages}})'
    >
        {{-- Grupos cadastrados --}}
        <template x-if="showGroupCards">
            <x-main-content>
                {{-- Menu utilitário das tabelas --}}
                <template x-if="committees">
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar banca', 'method' => 'showCreateModal']"
                        :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar bancas...'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadCommittees()'"
                        :class="'md:justify-start'"
                    />
                </template>
                {{-- Componente com o conteúdo --}}
                <template x-if="committees">
                    <x-evaluation.committees-content/>
                </template>
                {{-- Div exibida enquanto os dados não chegam no front --}}
                <x-feedback.loading/>
                {{-- Div exibida caso não haja registros no banco --}}
                <template x-if="isEmpty && !loading">
                    <x-feedback.empty-state :model="['banca', 'bancas']"/>
                </template>
                {{-- Paginação --}}
                <template x-if="page">
                    <x-feedback.pagination
                        :page-var="'page'"
                        :total-pages="'totalPages'"
                        :load-function="'loadCommittees'"
                    />
                </template>
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
