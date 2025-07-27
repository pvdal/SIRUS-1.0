<x-app-layout>
    <x-slot name="title">
        Grupos
    </x-slot>

    <x-slot name="header">
        <div x-data="{ showPaper: false }"
             x-on:toggle-paper.window="showPaper = $event.detail"
             class="flex items-center justify-between"
        >
            <div x-show="showPaper" x-cloak>
                <x-button x-on:click="$dispatch('voltar-papel')">Visualizar Grupos</x-button>
            </div>
            <h2 x-show="!showPaper" x-cloak class="font-semibold text-xl">Grupos cadastrados</h2>
        </div>
    </x-slot>

    <div
        x-data="groupsData()"
        x-on:voltar-papel.window="
                showGroupCards = true;
                showGroupPaper = false;
                paperUrl = '';
                $dispatch('toggle-paper', false);
            "
    >
        <template x-if="showGroupCards">
            <x-main-content>
                {{-- Menu utilitário das tabelas --}}
                <x-actions-table-bar
                    :primaryAction="['label' => 'Cadastrar grupo', 'method' => 'showCreateModal']"
                    :clearAction="['label' => 'Limpar filtros', 'method' => 'limparCampos()']"
                    searchModel="searchTerm"
                    statusFilter="statusFilter"
                    registerPeriod="registerPeriod"
                />

                {{-- Componente com o conteúdo --}}
                <x-management.groups-content :groups="$groups"/>

                {{-- Paginação nativa do Laravel --}}
                <div class="mt-6 mb-8">
                    {{-- $groups->links() --}}
                </div>
            </x-main-content>
        </template>

        <template x-if="showGroupPaper">
            <div class="relative">
                <!-- Mensagem ou Spinner de Carregando -->
                <div
                    x-show="isLoadingPdf"
                    class="absolute inset-0 z-10 flex items-center justify-center bg-white bg-opacity-75"
                >
                    <span class="text-gray-600 text-lg">Carregando PDF...</span>
                </div>

                <!-- Iframe do PDF -->
                <iframe
                    x-bind:src="paperUrl"
                    class="w-full h-[100vh] border border-gray-300 rounded-md"
                    type="application/pdf"
                    @load="isLoadingPdf = false"
                ></iframe>
            </div>
        </template>

    </div>
    @push('scripts')
        <script>
            function groupsData() {
                return {
                    showGroupCards: true,
                    showCreateModal: false,
                    shoeUpdateModal: false,
                    searchTerm: '',
                    statusFilter: '',
                    registerPeriod: '',
                    theme: '',
                    file_path: '',
                    saving: false,
                    showGroupPaper: false,
                    paperUrl: '',
                    isLoadingPdf: true,

                    showPaper(url) {
                        this.showGroupCards = false;
                        this.isLoadingPdf = true;
                        this.paperUrl = url;
                        this.showGroupPaper = true;
                        this.$dispatch('toggle-paper', true);
                        this.$nextTick(() => {
                            setTimeout(() => {
                                this.paperUrl = url;
                                this.showGroupPaper = true;
                                this.$dispatch('toggle-paper', true);
                            }, 10);
                        });
                    },
                }
            }
        </script>
    @endpush
</x-app-layout>
