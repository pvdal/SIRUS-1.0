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
            <!-- Componente com o conteúdo -->
            <x-course-content :cursos="$cursos" />

            <!-- Paginação Nativa do Laravel -->
            <div class="mt-6 mb-8">
                {{ $cursos->links() }}
            </div>
        </div>
    </x-main-content>
    @push('scripts')
        <script>
            function coursesData() {
                return {
                    showModal: false,
                    name: '',
                    shift: '',
                    coordinator_cpf: '',
                    errors: {},
                    saving: false,
                    showBanner: false,
                    message: '',
                    style: '',
                    // Lista reativa para adicionar novos cursos
                    novosCursos: [],

                    async salvarCurso() {
                        if (this.saving) return;
                        this.errors = {};
                        this.saving = true;

                        try {
                            const response = await axios.post('/courses/save', {
                                name: this.name,
                                shift: this.shift,
                                coordinator_cpf: this.coordinator_cpf
                            }, {
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json'
                                }
                            });

                            this.limparCampos();
                            this.showMessage('success', 'Curso salvo com sucesso!');

                            // Adiciona o novo curso na lista reativa (sem reload!)
                            const novoCurso = response.data.course;
                            this.novosCursos.unshift(novoCurso);

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

                    limparCampos() {
                        this.name = '';
                        this.shift = '';
                        this.coordinator_cpf = '';
                        this.errors = {};
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
