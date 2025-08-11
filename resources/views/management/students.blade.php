<x-app-layout>
    <x-slot name="title">
        Alunos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Alunos cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/studentsData.js--}}
        <div x-data="studentsData()"
             x-init='init(@json($students), @json($groups), @json($courses), {{ $current_page }}, {{ $last_page }})'>
            <x-nav-users-table> {{-- Navegação das tabelas de usuário --}}
                {{-- Menu utilitário das tabelas --}}
                <x-actions-table-bar
                    :primary-action="['label' => 'Cadastrar Aluno', 'method' => 'showCreateModal']"
                    :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                    :search-model="'searchTerm'"
                    :search-placeholder="'Buscar alunos por nome ou email...'"
                    :status-filter="'statusFilter'"
                    :register-period="'registerPeriod'"
                    :load-function="'loadStudents()'"
                />
                {{-- Componente com o conteúdo que o alpine vai manipular --}}
                <x-management.students-content/>
                {{-- Paginação --}}
                <x-management.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadStudents'"
                />
            </x-nav-users-table>
        </div>
    </x-main-content>
</x-app-layout>
