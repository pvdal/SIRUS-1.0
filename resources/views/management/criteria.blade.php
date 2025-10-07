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
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar Critério', 'method' => 'showCreateModal', 'additional' => 'edit = false;']"
                        :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar critérios...'"
                        :searchWidth="'xs:w-6/12'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadCriteria()'"
                        :class="'lg:justify-start'"
                    />

                    {{--Conteúdo que mostra os critérios cadastrados--}}
                    <x-management.criteria-content/>

                    <x-management.pagination
                        :page-var="'page'"
                        :total-pages="'totalPages'"
                        :load-function="'loadCriteria'"
                    />
                </x-nav-evaluation-table>
            </div>
        </x-main-content>
    {{-- Fechamento do novo menu --}}

</x-app-layout>
