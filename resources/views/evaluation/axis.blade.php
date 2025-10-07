<x-app-layout>
    <x-slot name="title">
        Eixos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Eixos cadastrados') }}
        </h2>
    </x-slot>

    <x-main-content>
        {{-- Seu AlpineJS data parece correto para inicializar os dados --}}
        <div x-data="axesData()"
             x-init='init(@json($axis), {{$amount}}, {{ $page }}, {{ $totalPages }})'>

            <x-nav-evaluation-table>
                <x-actions-table-bar
                    :primary-action="['label' => 'Cadastrar Eixo', 'method' => 'showCreateModal', 'additional' => 'edit = false;']"
                    :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                    :search-model="'searchTerm'"
                    :search-placeholder="'Buscar eixos...'"
                    :searchWidth="'xs:w-6/12'"
                    :status-filter="'statusFilter'"
                    :register-period="'registerPeriod'"
                    :load-function="'loadAxes()'"
                    :class="'md:justify-start'"
                />

                {{-- O conteúdo da tabela e modal está agora no componente abaixo --}}
                <x-evaluation.axis-content/>

                <x-management.pagination
                    :page-var="'page'"
                    :total-pages="'totalPages'"
                    :load-function="'loadAxes'"
                />
            </x-nav-evaluation-table>
        </div>
    </x-main-content>

</x-app-layout>
