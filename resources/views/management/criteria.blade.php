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
                        />
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
            </div>
        </x-main-content>
    {{-- Fechamento do novo menu --}}

</x-app-layout>
