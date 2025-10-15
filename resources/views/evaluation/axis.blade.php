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
                <template x-if="axes">
                    <x-actions-table-bar
                        :primary-action="['label' => 'Cadastrar Eixo', 'method' => 'showCreateModal', 'additional' => 'edit = false;']"
                        :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                        :search-model="'searchTerm'"
                        :search-placeholder="'Buscar eixos...'"
                        :status-filter="'statusFilter'"
                        :register-period="'registerPeriod'"
                        :load-function="'loadAxes()'"
                        :class="'md:justify-start'"
                    />
                </template>
                {{-- O conteúdo da tabela e modal está agora no componente abaixo --}}
                <template x-if="axes">
                    <x-evaluation.axis-content/>
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
                        :load-function="'loadAxes'"
                    />
                </template>
            </x-nav-evaluation-table>
        </div>
    </x-main-content>

</x-app-layout>
