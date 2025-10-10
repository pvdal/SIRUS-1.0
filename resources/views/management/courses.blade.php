<x-app-layout>
    <x-slot name="title">
        Cursos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Cursos cadastrados') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/management/coursesData.js--}}
        <div x-data="coursesData()"
             x-init='init(@json($courses), @json($coordinators), {{ $page}}, {{ $totalPages}})'>
            {{-- Menu utilitário das tabelas --}}
            <template x-if="courses">
                <x-actions-table-bar
                    :primaryAction="['label' => 'Cadastrar Curso', 'method' => 'showCreateModal']"
                    :clearAction="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                    :searchModel="'searchTerm'"
                    :search-placeholder="'Buscar cursos...'"
                    :statusFilter="'statusFilter'"
                    :registerPeriod="'registerPeriod'"
                    :loadFunction="'loadCourses()'"
                    :class="'md:justify-start'"
                />
            </template>
            {{-- Componente com o conteúdo que o alpine vai manipular --}}
            <template x-if="courses">
                <x-management.courses-content/>
            </template>
            {{-- Div exibida enquanto os dados não chegam no front --}}
            <x-feedback.loading/>
            {{-- Div exibida caso não haja registros no banco --}}
            <template x-if="isEmpty && !loading">
                <x-feedback.empty-state :model="['curso', 'cursos']"/>
            </template>
            {{-- Paginação --}}
            <template x-if="page">
                <x-feedback.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadCourses'"
                />
            </template>
        </div>
    </x-main-content>
</x-app-layout>
