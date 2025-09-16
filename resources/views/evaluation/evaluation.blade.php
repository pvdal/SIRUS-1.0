<x-app-layout>
    <x-slot name="title">
        Avaliações
    </x-slot>

    <x-slot name="header">
        <div x-data="{ showPaper: false }"
             x-on:toggle-paper.window="showPaper = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('toggle-groups')">Visualizar Avaliação</x-button>
            </div>
            <h2 x-show="!showPaper" x-cloak class="font-semibold text-xl">Configurar Avaliação</h2>
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
        x-init='init(@json($committees), @json($member_types), @json($groups), @json($academicStaff), {{ $current_page }}, {{ $last_page }})'
    >
        {{-- Grupos cadastrados --}}
        <template x-if="showGroupCriteria">
            <x-main-content>
                {{-- Menu utilitário das tabelas --}}
                <x-actions-table-bar
                    :primary-action="['label' => 'Cadastrar avaliação', 'method' => 'showCreateModal']"
                    :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                    :search-model="'searchTerm'"
                    :status-filter="'statusFilter'"
                    :register-period="'registerPeriod'"
                    :load-function="'loadCommittees()'"
                    :class="'md:justify-start'"
                />
                {{-- Componente com o conteúdo --}}
                <x-evaluation.committees-content/>
                {{-- Paginação --}}
                <x-management.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadCommittees'"
                />
            </x-main-content>
        </template>

    </div>
</x-app-layout>
