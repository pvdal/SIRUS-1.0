<x-app-layout>
    <x-slot name="title">
        Coordenadores
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Coordenadores cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/coordinatorsData.js--}}
        <div x-data="coordinatorsData()"
             x-init='init(@json($coordinators), {{ $page}}, {{ $totalPages}})'>
            <x-nav-users-table> {{-- Navegação das tabelas de usuário --}}
                {{-- Menu utilitário das tabelas --}}
                <template x-if="coordinators">
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar Coordenador', 'method' => 'showCreateModal']"
                        :clear-action="['label' => 'Limpar Filtros', 'method' => 'clearFields', 'param' => 'filters' ]"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar coordenadores...'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadCoordinators()'"
                        :class="'md:justify-start'"
                    />
                </template>
                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <template x-if="coordinators">
                    <x-management.coordinators-content/>
                </template>
                {{-- Div exibida enquanto os dados não chegam no front --}}
                <x-feedback.loading/>
                {{-- Div exibida caso não haja registros no banco --}}
                <template x-if="isEmpty && !loading">
                    <x-feedback.empty-state :model="['estudante', 'estudantes']"/>
                </template>
                {{-- Paginação --}}
                <template x-if="page">
                    <x-feedback.pagination
                        :page-var="'page'"
                        :total-pages="'totalPages'"
                        :load-function="'loadCoordinators'"
                    />
                </template>
            </x-nav-users-table>
        </div>
    </x-main-content>
</x-app-layout>
