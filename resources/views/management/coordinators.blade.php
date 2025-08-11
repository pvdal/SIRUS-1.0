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
             x-init='init(@json($coordinators), {{ $current_page }}, {{ $last_page }})'>
            <x-nav-users-table> {{-- Navegação das tabelas de usuário --}}
                {{-- Menu utilitário das tabelas --}}
                <x-actions-table-bar
                    :primary-action="['label' => 'Cadastrar Coordenador', 'method' => 'showCreateModal']"
                    :clear-action="['label' => 'Limpar Filtros', 'method' => 'clearFields', 'param' => 'filters' ]"
                    :search-model="'searchTerm'"
                    :status-filter="'statusFilter'"
                    :register-period="'registerPeriod'"
                    :load-function="'loadCoordinators()'"
                />
                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <x-management.coordinators-content/>
                {{-- Paginação --}}
                <x-management.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadCoordinators'"
                />
            </x-nav-users-table>
        </div>
    </x-main-content>
</x-app-layout>
