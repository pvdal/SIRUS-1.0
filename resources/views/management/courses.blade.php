<x-app-layout>
    <x-slot name="title">
        Cursos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Cursos cadastrados') }}
        </h2>
    </x-slot>

    <x-main-content>
        <div x-data="coursesData()">
            {{-- Menu utilitário das tabelas --}}
            <x-actions-table-bar
                :primaryAction="['label' => 'Cadastrar Curso', 'method' => 'showCreateModal']"
                :clearAction="['label' => 'Limpar filtros', 'method' => 'limparCampos()']"
                searchModel="searchTerm"
                statusFilter="statusFilter"
                registerPeriod="registerPeriod"
            />

            {{-- Componente com o conteúdo --}}
            <x-management.courses-content :courses="$courses" :coordinators="$coordinators"/>

            {{-- Paginação Nativa do Laravel --}}
            <div class="mt-6 mb-8">
                {{ $courses->links() }}
            </div>
        </div>
    </x-main-content>
    @push('scripts')
        <script>
            function coursesData() {
                return {
                    showCreateModal: false,
                    showUpdateModal: false,
                    searchTerm: '',
                    statusFilter: '',
                    registerPeriod: '',
                    name: '',
                    shift: '',
                    coordinator_id: '',
                    errors: {},
                    saving: false,
                    showBanner: false,
                    message: '',
                    style: '',
                    {{-- Lista reativa para adicionar novos cursos --}}
                    newCourses: [],

                    {{--Dicionário de tradução para os turnos do curso --}}
                    translateShift(shift) {
                        return {
                            'morning': 'Manhã',
                            'afternoon': 'Tarde',
                            'night': 'Noite'
                        }[shift.toLowerCase()] || shift;
                    },

                    async salvarCurso() {
                        if (this.saving) return;
                        this.errors = {};
                        this.saving = true;

                        try {
                            const response = await axios.post('/courses/save', {
                                name: this.name,
                                shift: this.shift,
                                coordinator_id: this.coordinator_id
                            }, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                }
                            });

                            this.limparCampos('create');
                            this.showMessage('success', 'Curso salvo com sucesso!');

                            {{-- Adiciona o novo curso na lista reativa (sem reload!) --}}
                            const newCourse = response.data.course;
                            newCourse.shift_pt = this.translateShift(newCourse.shift);
                            {{-- Adiciona a lista reativa --}}
                            this.newCourses.unshift(newCourse);

                        } catch (error) {
                            if (error.response && error.response.status === 422) {
                                this.errors = error.response.data.errors;
                                this.showMessage('warning', 'Verifique os dados informados!');
                            } else {
                                this.showMessage('danger', 'Erro inesperado ao salvar.');
                                console.error(error);
                            }
                        } finally {
                            this.saving = false;
                        }
                    },

                    limparCampos($type) {
                        switch ($type){
                            case 'form':
                                this.name = '';
                                this.shift = '';
                                this.coordinator_id = '';
                                break;
                            case 'filters':
                                this.searchTerm = '';
                                this.statusFilter = '';
                                this.registerPeriod = '';
                                break;
                            default:
                                this.limparCampos('form');
                                this.limparCampos('filters');
                                break;
                        }
                    },

                    showMessage(style, message) {
                        this.style = style;
                        this.message = message;
                        this.showBanner = true;
                        setTimeout(() => {
                            this.showBanner = false;
                        }, 3000);
                    }
                }
            }
        </script>
    @endpush
</x-app-layout>
