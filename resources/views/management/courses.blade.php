<x-app-layout>
    <x-slot name="title">
        Cursos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Cursos cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/coursesData.js--}}
        <div x-data="coursesData()"
             x-init='init(@json($courses), @json($coordinators), {{ $current_page }}, {{ $last_page }})'>
            {{-- Menu utilitário das tabelas --}}
            <x-actions-table-bar
                :primaryAction="['label' => 'Cadastrar Curso', 'method' => 'showCreateModal']"
                :clearAction="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                :searchModel="'searchTerm'"
                :statusFilter="'statusFilter'"
                :registerPeriod="'registerPeriod'"
                :loadFunction="'loadCourses()'"
            />
            {{-- Componente com o conteúdo que o alpine vai manipular --}}
            <x-management.courses-content/>
            {{-- Paginação --}}
            <x-management.pagination
                :page-var="'page'"
                :total-pages="'totalPages'"
                :load-function="'loadCourses'"
            />
        </div>
    </x-main-content>
</x-app-layout>
