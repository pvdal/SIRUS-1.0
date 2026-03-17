<x-app-layout>
    <x-slot name="title">
        Bancas
    </x-slot>

    <x-slot name="header">
        @php
            if(auth()->user()->can('manage-events')) {
                $header = 'Bancas cadastradas';
            } else {
                $header = 'Histórico de avaliações';
            }
        @endphp
        <h2 id="page-title" x-text="window.headerTitle ?? ''" class="font-semibold text-xl leading-tight">{{ $header }}</h2>
        <div x-data="{ showPaper: false, showHistory: false }"
             x-init="document.getElementById('page-title')?.remove()"
             x-on:toggle-paper.window="showPaper = $event.detail"
             x-on:toggle-history.window="showHistory = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('toggle-groups'); $dispatch('toggle-nav-bar', true);">Visualizar Bancas</x-button>
            </div>
            <div x-show="showHistory && !showPaper" x-cloak>
                <h2 class="font-semibold text-xl leading-tight">Histórico de avaliações</h2>
            </div>
            <h2 x-show="!showPaper && !showHistory" x-cloak class="font-semibold text-xl leading-tight">{{ $header }}</h2>
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
        x-init='init(@json($committees), @json($member_types), @json($groups), {{ $page}}, {{ $totalPages}})'
    >
        {{-- Grupos cadastrados --}}
        <div x-show="showGroupCards">
            <x-main-content>
                {{-- Menu utilitário das tabelas --}}
                @can('manage-events')
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
                        >
                            <button
                                id="clearAction"
                                type="button"
                                x-on:click="
                                $el.blur();
                                historyFilter = !historyFilter;
                                loadCommittees();
                            "
                                :class="{
                                'appearance-none border border-gray-300 rounded-lg me-1 min-w-[170px] px-6 py-2.5 mb-2 xs:me-2 text-sm text-gray-700 dark:!text-gray-200 focus:ring-3 focus:ring-secondary-blue focus:border-secondary-blue cursor-pointer inline-flex items-center justify-between gap-2 transition duration-150 ease-in-out': true,
                                '!bg-secondary-blue !text-white': historyFilter,
                            }"
                                title="Meu histórico"
                            >
                                Meu histórico
                                <x-lucide-history
                                    class="w-4 h-4 text-gray-500 dark:!text-gray-200 transition duration-150 ease-in-out"
                                    x-bind:class="{'!text-white': historyFilter}"
                                />
                            </button>
                        </x-actions-table-bar>
                    </template>
                @endcan
                @if(auth()->user()->canEvaluate() && !auth()->user()->canManageEvents())
                    <template x-if="committees">
                        <x-actions-table-bar
                            :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                            :search-model="'searchTerm'"
                            :search-placeholder="'Buscar bancas...'"
                            :register-period="'registerPeriod'"
                            :load-function="'loadCommittees()'"
                            :class="'md:justify-start'"
                        />
                    </template>
                @endif
                {{-- Componente com o conteúdo --}}
                <template x-if="committees">
                    <x-evaluation.committees-content/>
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
                        :load-function="'loadCommittees'"
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
