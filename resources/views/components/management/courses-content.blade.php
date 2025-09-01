<div>
    {{-- Modal de cadastro --}}
    <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
        <x-slot name="title">
            <template x-if="!edit">
                <span>Cadastrar novo curso</span>
            </template>
            <template x-if="edit">
                <span>Atualizar os dados do curso</span>
            </template>
        </x-slot>

        <x-slot name="content">
            <!-- Banner de mensagem -->
            <x-custom-banner/>
            {{-- Formulário --}}
            <div>
                <x-form-fields.course/>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button type="button" x-bind:disabled="saving"
                x-on:click="
                    saveCourse;
                    $el.blur();
                "
            >
                <span x-show="!saving">Salvar</span>
                <span x-show="saving">Salvando...</span>
            </x-secondary-button>
            <x-danger-button type="button"
                x-on:click="
                    showCreateModal = false;
                    clearFields('store');
                "
            >
                Fechar
            </x-danger-button>
        </x-slot>
    </x-custom-modal>
    {{-- Component modal para avisos --}}
    <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields('warning');" :maxWidth="'sm'">
        <x-slot name="title">
            <div class="flex items-center gap-2">
                <template x-if="warningType === 'Confirmação'">
                    <div class="flex items-center gap-2 text-secondary-orange">
                        <div class="bg-secondary-orange rounded-[20px] p-2">
                            <x-lucide-alert-triangle class="text-white w-5 h-5" />
                        </div>
                        <span x-text="warningType" class="font-semibold"></span>
                    </div>
                </template>
                <template x-if="warningType === 'Erro'">
                    <div class="flex items-center gap-2 text-red-700">
                        <div class="bg-red-700 rounded-[20px] p-2">
                            <x-lucide-x-circle class="text-white w-5 h-5" />
                        </div>
                        <span x-text="warningType" class="font-semibold"></span>
                    </div>
                </template>
            </div>
        </x-slot>

        <x-slot name="content">
            <template x-if="warningContent">
                <p x-text="warningContent"></p>
            </template>
        </x-slot>

        <x-slot name="footer">
            <template x-if="warningType === 'Confirmação'">
                <x-danger-button type="button"
                    x-on:click="
                        toggleStatus();
                        $el.blur();
                    "
                >
                    Inativar
                </x-danger-button>
            </template>
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="ms-4">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>
    <div class="py-5 px-2">
        {{-- Tabela de registros: recebe os dados iniciais direto do controller e na paginação recebe os dados pro ajax --}}
        <table class="min-w-full border border-gray-300 divide-y divide-gray-200">
            <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">ID</th>
                <th class="px-4 py-2 text-center text-gray-700">Nome</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">Turno</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Coordenador</th>
                <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Estado</th>
                <th class="px-4 py-2 text-center text-gray-700">Ações</th>
            </tr>
            </thead>
            <tbody class="bg-white">
            <template x-for="course in [...newCourses, ...courses]" :key="course.id">
                <tr :class="
                    {
                        'hover:bg-gray-50': true,
                        'bg-green-50': course.origin === 'new',
                    }"
                    x-transition:enter="transition ease-out duration-500"
                    x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                    x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                >
                    <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="course.id"></td>
                    <td class="px-4 py-2 border text-center border-gray-300" x-text="course.name"></td>
                    <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell" x-text="course.shift_pt"></td>
                    <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" :class="course.coordinator_state == 0 && course.coordinator_name ? 'line-through text-gray-400' : ''" x-text="course.coordinator_name || '-'"></td>
                    <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell" x-text="course.state ? 'Ativo' : 'Inativo'"></td>
                    <td class="px-4 py-2 border text-center border-gray-300">
                        <template x-if="course.state">
                            <x-button type="button" class="min-w-[98px]"
                                x-on:click="
                                    showCourse(course.id);
                                    $el.blur();
                                "
                            >
                                Alterar
                            </x-button>
                        </template>

                        <template x-if="course.state">
                            <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(course.id)"
                                x-on:click="
                                    warning('confirmação', course.name, course.id);
                                    $el.blur();
                                "
                            >
                                <template x-if="isInactivating(course.id)">
                                    <span>Inativando...</span>
                                </template>
                                <template x-if="!isInactivating(course.id)">
                                    <span>Inativar</span>
                                </template>
                            </x-danger-button>
                        </template>
                        <template x-if="!course.state">
                            <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(course.id)"
                                x-on:click="
                                    toggleStatus(course.id);
                                    $el.blur();
                                "
                            >
                                <template x-if="isActivating(course.id)">
                                    <span>Ativando...</span>
                                </template>
                                <template x-if="!isActivating(course.id)">
                                    <span>Ativar</span>
                                </template>
                            </x-management.activate-button>
                        </template>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
    <div x-show="loading" class="flex justify-center py-4">
        <svg class="animate-spin h-6 w-6 text-secondary-blue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10"
                    stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                  d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
            </path>
        </svg>
    </div>
    <template x-if="empty">
        <div class="flex flex-col items-center justify-center pb-8 pt-2 text-center">
            <p class="text-gray-700 text-md font-medium">
                Nenhum curso foi cadastrado até o momento.
            </p>
            <p class="text-gray-500 mt-1 text-sm">
                Assim que houverem cursos registrados, eles aparecerão aqui.
            </p>
        </div>
    </template>
</div>
