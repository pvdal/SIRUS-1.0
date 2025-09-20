<x-app-layout>
    <x-slot name="title">
        Professores
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Professores cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/professorsData.js--}}
        <div x-data="professorsData()"
             x-init='init(@json($professors), {{ $page}}, {{ $totalPages}})'>
            <x-nav-users-table> {{-- Navegação das tabelas de usuário --}}
                {{-- Menu utilitário das tabelas --}}
                <x-actions-table-bar
                    :primary-action="['label' => 'Cadastrar Professor', 'method' => 'showCreateModal']"
                    :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields', 'param' => 'filters']"
                    :search-model="'searchTerm'"
                    :status-filter="'statusFilter'"
                    :register-period="'registerPeriod'"
                    :load-function="'loadProfessors()'"
                    :class="'md:justify-start'"
                />
                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <x-management.professors-content/>
                {{-- Paginação --}}
                <x-management.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadProfessors'"
                />
            </x-nav-users-table>
        </div>
    </x-main-content>
</x-app-layout>
