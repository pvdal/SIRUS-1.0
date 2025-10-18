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
        <div x-data="{ showModelView: false }"
             x-on:toggle-rubric-model.window="showModelView = $event.detail"
             class="flex items-center justify-between"
        >
            {{-- Botão "Voltar" que aparece na visão do modelo --}}
            <div x-show="showModelView" x-cloak>
                <x-button x-on:click="$dispatch('toggle-rubric-cards')">
                    <x-lucide-arrow-left class="w-4 h-4 mr-2"/>
                    Visualizar Rubricas
                </x-button>
            </div>
            {{-- Titulo principal que aparece na visão dos cards --}}
            <h2 x-show="!showModelView" x-cloak class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Rubricas Cadastradas
            </h2>
        </div>
    </x-slot>

    {{-- Chamada da função alpine -> recources/js/components/management/rubricsData.js--}}
            <x-main-content>
    <div x-data="rubricsData()"
        x-on:toggle-rubric-cards.window="
        showRubricCards = true;
        showModelIframe = false;
        modelIframeUrl = '';
        $dispatch('toggle-rubric-model', false);
        "
        x-init='init(@json($rubrics), {{ $page }}, {{ $totalPages }})'
    >
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

                    <template x-if="page && !loading">
                        <x-feedback.pagination
                            :page-var="'page'"
                            :total-pages="'totalPages'"
                            :load-function="'loadRubrics'"
                        />
                    </template>
                </x-nav-evaluation-table>


        </div>
            <template x-if="rubricForModelView">
                <x-evaluation.rubric-preview/>
            </template>

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

    </div>
            </x-main-content>
</x-app-layout>
