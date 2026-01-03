<x-app-layout>
    <x-slot name="title">
        Rubricas
    </x-slot>

    {{--    <x-slot name="header">--}}
    {{--        <h2 class="font-semibold text-xl text-dark leading-tight">--}}
    {{--            {{ __('Rubricas cadastradas') }}--}}
    {{--        </h2>--}}
    {{--    </x-slot>--}}

    <x-slot name="header">
        {{-- Tem que haver um título padrão aqui, proque o Alpine carrega por último, então haveria uma header em branco por alguns milisegundos --}}
        <h2 id="page-title" x-text="window.headerTitle ?? ''" class="font-semibold text-xl leading-tight">Rubricas Cadastradas</h2> {{-- Removido após carregamento do Alpine --}}
        <div x-data="{ showModelView: false }"
             x-init="document.getElementById('page-title')?.remove()"
             x-on:toggle-rubric-model.window="showModelView = $event.detail"
             class="flex items-center justify-between"
        >
            {{-- Botão "Voltar" que aparece na visão do modelo --}}
            <div x-show="showModelView" x-cloak>
                <x-button x-on:click="$dispatch('toggle-rubric-cards');">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2"/>
                    Visualizar Rubricas
                </x-button>
            </div>
            {{-- Titulo principal que aparece na visão dos cards --}}
            <h2 x-show="!showModelView" x-cloak class="font-semibold text-xl leading-tight">Rubricas Cadastradas</h2>
        </div>
    </x-slot>

    {{-- Chamada da função alpine -> recources/js/components/management/rubricsData.js--}}
    <div x-data="rubricsData()"
            x-on:toggle-rubric-cards.window="
            showRubricCards = true;
            showModel = false;
            modelIframeUrl = '';
            $dispatch('toggle-rubric-model', false);
        "
        x-init='init(@json($rubrics), {{ $page }}, {{ $totalPages }})'
    >
        <x-main-content>
            <div x-show="showRubricCards">
                <x-nav-evaluation-table>
                    <template x-if="rubrics">
                        <x-actions-table-bar
                            :primary-action="['label' => 'Cadastrar Rubrica', 'method' => 'showCreateModal' ]"
                            :clear-action="['label' => 'Limpar filtros', 'method' => 'clearFields()']"
                            :search-model="'searchTerm'"
                            :search-placeholder="'Buscar Rubricas...'"
                            :status-filter="'statusFilter'"
                            :register-period="'registerPeriod'"
                            :load-function="'loadRubrics()'"
                            :class="'md:justify-start'"
                        />
                    </template>
                    {{-- O conteúdo da tabela e modal está agora no componente abaixo --}}
                    <template x-if="rubrics">
                         {{-- Component e com o conteúdo --}}
                        <x-evaluation.rubrics-content/>
                    </template>
                    {{-- Div exibida enquanto os dados não chegam no front --}}
                    <x-feedback.loading/>
                    {{-- Div exibida caso não haja registros no banco --}}
                    <template x-if="isEmpty">
                        <x-feedback.empty-state />
                    </template>
                    {{-- Paginação --}}
                    <template x-if="page && !loading">
                        <x-feedback.pagination
                            :page-var="'page'"
                            :total-pages="'totalPages'"
                            :load-function="'loadRubrics'"
                        />
                    </template>
                </x-nav-evaluation-table>
            </div>

            {{-- Alternativa para manter a animação e evitar o flash (aparição seguida de remoção rápida) com conteúdo da banca --}}
            <div
                x-show="showModel"
                x-cloak
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
            >
                <template x-if="rubricForModelView">
                    <x-evaluation.rubric-preview />
                </template>
            </div>

            {{--    Visualização das Rubricas--}}
            {{--        <div x-show="showModelIframe" x-transition>--}}
            {{--            <div class="p-4 sm:p-6">--}}
            {{--                <x-secondary-button @click="hideRubricModel()">--}}
            {{--                    <x-lucide-arrow-left class="w-4 h-4 mr-2"/>--}}
            {{--                    Voltar para a Lista de Rúbricas--}}
            {{--                </x-secondary-button>--}}

            {{--                <div class="mt-4 border rounded-lg overflow-hidden shadow-lg">--}}
            {{--                    <iframe--}}
            {{--                        :src="modelIframeUrl"--}}
            {{--                        frameborder="0"--}}
            {{--                        class="w-full h-[80vh]" --}}{{-- Altura de 80% da tela --}}
            {{--                    ></iframe>--}}
            {{--                </div>--}}
            {{--            </div>--}}
            {{--        </div>--}}

            {{--        Sem iframe--}}
        </x-main-content>
    </div>
</x-app-layout>
