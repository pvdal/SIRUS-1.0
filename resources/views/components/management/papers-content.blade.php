<div>
    {{-- Modal de cadastro --}}
    <template x-if="showGroupCards">
        <x-custom-modal x-model="showCreateModal" @close="showCreateModal = false; clearFields('store')">
            <x-slot name="title">
                <div class="flex flex-wrap items-center justify-start gap-3">
                    <h1 class="me-auto text-lg font-semibold text-gray-700 dark:text-gray-200">
                        <template x-if="!edit">
                            <span>Cadastrar novo trabalho</span>
                        </template>
                        <template x-if="edit">
                            <span>Atualizar os dados do trabalho</span>
                        </template>
                    </h1>
                    <template x-if="edit">
                        <div>
                            <template x-if="submitted_at">
                                <div class="inline-flex gap-1 items-center justify-center text-blue-700 dark:text-blue-400">
                                    <x-lucide-check class="w-4 h-4"/>
                                    <span class="font-normal text-sm" x-text="'Avaliado em: ' + submitted_at"></span>
                                </div>
                            </template>
                            <template x-if="!submitted_at && !corrected_version">
                                <div>
                                    <template x-if="schedule.start && schedule.end">
                                        <div class="inline-flex gap-1 items-center justify-center text-yellow-700 dark:text-yellow-500">
                                            <x-lucide-circle-alert class="w-4 h-4"/>
                                            <span class="font-normal text-sm">Avaliação pendente</span>
                                        </div>
                                    </template>
                                    <template x-if="!schedule.start && !schedule.end && edit">
                                        <div class="inline-flex gap-1 items-center justify-center text-yellow-700 dark:text-yellow-500">
                                            <x-lucide-circle-alert class="w-4 h-4"/>
                                            <span class="font-normal text-sm">Avaliação não agendada</span>
                                        </div>
                                    </template>
                                </div>
                            </template>
                            <template x-if="corrected_version">
                                <div class="inline-flex gap-1 items-center justify-center text-green-600">
                                    <x-lucide-check class="w-4 h-4"/>
                                    <span class="font-normal text-sm" x-text="'Versão corrigida'"></span>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>
            </x-slot>

            <x-slot name="content">
                {{-- Banner de mensagem --}}
                <x-custom-banner/>
                {{-- Formulário --}}
                <x-form-fields.paper :courses="$courses"/>
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button type="button" x-bind:disabled="saving"
                    x-on:click="
                        savePaper();
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
                        $el.blur();
                    "
                >
                    Fechar
                </x-danger-button>
            </x-slot>
        </x-custom-modal>
    </template>

    {{-- Component modal para avisos --}}
    <x-warning-modal x-model="showWarningModal" @close="showWarningModal = false; clearFields('warning');" :maxWidth="'sm'" :warningType="'warningType'">
        <x-slot name="title">
            <template x-if="warningType">
                <span x-text="warningType" class="font-semibold"></span>
            </template>
        </x-slot>

        <x-slot name="content">
            <template x-if="warningContent">
                <p class="break-words" x-text="warningContent"></p>
            </template>
        </x-slot>

        <x-slot name="footer">
            <template x-if="warningType === 'Confirmação'">
                <x-danger-button type="button"
                    x-on:click="
                        toggleStatus();
                        $el.blur();
                    "
                    x-text="warningAction"
                >
                </x-danger-button>
            </template>
            <x-secondary-button type="button" @click="showWarningModal = false; clearFields('warning');" class="min-w-[98px]">
                Voltar
            </x-secondary-button>
        </x-slot>
    </x-warning-modal>
    {{-- View dos cards --}}
    <div x-show="!isEmpty && !loading" class="mx-auto" :class="{ 'py-5 px-2': !showDirectories, 'py-1 px-6': showDirectories}">
        {{-- Tabela de arquivos --}}
        <template x-if="!showDirectories">
            <x-table.content
                :items="'papers'"
                :new-items="'newPapers'"
                :item-key="'id'"
                :haveActions="true"
            >
                <x-slot name="columns">
                    <x-table.th class="hidden md:table-cell">ID</x-table.th>
                    <x-table.th>Nome</x-table.th>
                    <x-table.th class="hidden md:table-cell">Grupo</x-table.th>
                    <x-table.th class="hidden lg:table-cell">Avaliação</x-table.th>
                    <x-table.th class="hidden lg:table-cell">Status</x-table.th>
                </x-slot>
                <x-slot name="rows">
                    <x-table.td class="hidden md:table-cell" x-text="item.id"></x-table.td>
                    <x-table.td class="break-all" x-text="item.title"></x-table.td>
                    <x-table.td class="hidden md:table-cell" x-text="item.group_theme"></x-table.td>
                    <x-table.td class="hidden lg:table-cell" x-text="item.version === 'corrected' ? 'Corrigido' : (item.submitted_at ?? 'Não avaliado')"></x-table.td>
                    <x-table.td class="hidden lg:table-cell" x-text="item.state == 1 ? 'Ativo' : 'Inativo'"></x-table.td>
                </x-slot>
                <x-slot name="actions">
                    <div class="flex flex-wrap gap-2 items-center justify-center">
                        <template x-if="item.state">
                            <x-button type="button" class="min-w-[98px]"
                                x-on:click="
                                    editPaper(item.id);
                                    $el.blur();
                                "
                            >
                                Alterar
                            </x-button>
                        </template>

                        <template x-if="item.state">
                            <x-danger-button type="button" class="min-w-[98px]" x-bind:disabled="isInactivating(item.id)"
                                x-on:click="
                                    warning('confirmação', item.title, item.id, 'inativar');
                                    $el.blur();
                                "
                            >
                                <template x-if="isInactivating(item.id)">
                                    <span>Inativando...</span>
                                </template>
                                <template x-if="!isInactivating(item.id)">
                                    <span>Inativar</span>
                                </template>
                            </x-danger-button>
                        </template>

                        <template x-if="!item.state">
                            <x-management.activate-button type="button" class="min-w-[98px]" x-bind:disabled="isActivating(item.id)"
                                x-on:click="
                                    warning('confirmação', item.title, item.id, 'ativar');
                                    $el.blur();
                                "
                            >
                                <template x-if="isActivating(item.id)">
                                    <span>Ativando...</span>
                                </template>
                                <template x-if="!isActivating(item.id)">
                                    <span>Ativar</span>
                                </template>
                            </x-management.activate-button>
                        </template>
                    </div>
                </x-slot>
            </x-table.content>
        </template>

        {{-- Visualizar diretórios --}}
        <template x-if="showDirectories">
            <div class="pb-5 pt-2">
                {{-- Mostra o path --}}
                <div class="flex flex-wrap items-center gap-2 text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out">
                    <x-lucide-house class="h-4 w-4"/>
                    <template x-for="(step,index) in nav">
                        <div class="inline-flex items-center justify-center gap-2 hover:text-gray-800 dark:hover:text-gray-200">
                            <span
                                class=" hover:cursor-pointer hover:underline"
                                x-on:click="
                                step.action();
                                $el.blur();
                            "
                                x-text="step.label">
                            </span>
                            <span x-show="index < nav.length -1">
                                <x-lucide-chevron-right class="w-4 h-4"/>
                            </span>
                        </div>
                    </template>
                </div>

                {{-- Explorador de arquivos --}}
                <div class="flex flex-col mt-8 justify-center md:grid md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-4 items-center transition-all duration-150 ease-in-out">
                    {{-- Mostra os anos salvos --}}
                    <template x-for="year in (folders ? Object.keys(folders) : [])" :key="year">
                        <button
                            x-show="currentLevel === 'root'"
                            type="button"
                            class="flex flex-col p-2 rounded-md gap-x-2 justify-center items-start shadow-sm border border-gray-300
                            hover:cursor-pointer hover:bg-soft-blue hover:shadow-md
                            w-full xs:w-[400px] md:w-auto max-w-full"
                            x-on:click="navigateTo('year',year)"
                        >
                            <div class="inline-flex items-center gap-2">
                                <x-lucide-folder class="flex-shrink-0 h-6 w-6 text-secondary-blue" stroke-width="1.5"/>
                                <span x-text="year" class="font-medium text-lg text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                            </div>
                            <div class="ms-8">
                                <span
                                    x-text="Object.keys(folders[year]).length +
                                        (Object.keys(folders[year]).length > 1 ? ' itens' : ' item')"
                                    class="text-sm text-gray-600 dark:text-gray-400 transition duration-150 ease-in-out">
                                </span>
                            </div>
                        </button>
                    </template>

                    {{-- Mostra os semestres salvos --}}
                    <template x-for="semester in (folders[selected.year] ? Object.keys(folders[selected.year]) : [])" :key="semester">
                        <button
                            x-show="currentLevel === 'year'"
                            type="button"
                            class="flex flex-col p-2 rounded-md gap-x-2 justify-center items-start shadow-sm border border-gray-300
                                hover:cursor-pointer hover:bg-soft-blue hover:shadow-md
                                w-full xs:w-[400px] md:w-auto max-w-full"
                            x-on:click="navigateTo('semester',semester)"
                        >
                            <div class="inline-flex items-center gap-2">
                                <x-lucide-folder class="flex-shrink-0 h-6 w-6 text-secondary-blue" stroke-width="1.5"/>
                                <span x-text="'Semestre ' + semester" class="font-medium text-lg text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                            </div>
                            <div class="ms-8">
                        <span
                            x-text="Object.keys(folders[selected.year][semester]).length +
                                (Object.keys(folders[selected.year][semester]).length > 1 ? ' itens' : ' item')"
                            class="text-sm text-gray-600 dark:text-gray-400 transition duration-150 ease-in-out">
                        </span>
                            </div>
                        </button>
                    </template>

                    {{-- Mostra as versões salvas --}}
                    <template
                        x-for="version in (folders[selected.year]?.[selected.semester]
                            ? Object.keys(folders[selected.year][selected.semester])
                            : [])"
                        :key="version"
                    >
                        <button
                            x-show="currentLevel === 'semester'"
                            type="button"
                            class="flex flex-col p-2 rounded-md gap-x-2 justify-center items-start shadow-sm border border-gray-300
                                hover:cursor-pointer hover:bg-soft-blue hover:shadow-md
                                w-full xs:w-[400px] md:w-auto max-w-full"
                            x-on:click="navigateTo('version', version)"
                        >
                            <div class="inline-flex items-center gap-2">
                                <x-lucide-folder class="flex-shrink-0 h-6 w-6 text-secondary-blue" stroke-width="1.5"/>
                                <span x-text="version === 'evaluation' ? 'Avaliação' : (version === 'corrected' ? 'Corrigido' : 'sem nome')"
                                      class="font-medium text-lg text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                            </div>
                            <div class="ms-8">
                        <span
                            x-text="Object.keys(folders[selected.year][selected.semester][version]).length +
                                (Object.keys(folders[selected.year][selected.semester][version]).length > 1 ? ' itens' : ' item')"
                            class="text-sm text-gray-600 dark:text-gray-400 transition duration-150 ease-in-out">
                        </span>
                            </div>
                        </button>
                    </template>

                    {{-- Mostra os cursos salvos --}}
                    <template
                        x-for="course in (folders[selected.year]?.[selected.semester]?.[selected.version]
                        ? Object.keys(folders[selected.year][selected.semester][selected.version])
                        : [])"
                        :key="course"
                    >
                        <button
                            x-show="currentLevel === 'version'"
                            type="button"
                            class="flex flex-col p-2 rounded-md gap-x-2 justify-center items-start shadow-sm border border-gray-300
                        hover:cursor-pointer hover:bg-soft-blue hover:shadow-md
                        w-full xs:w-[400px] md:w-auto max-w-full"
                            x-on:click="navigateTo('course',course)"
                        >
                            <div class="inline-flex items-center gap-2 max-w-full overflow-hidden">
                                <x-lucide-folder class="flex-shrink-0 h-6 w-6 text-secondary-blue" stroke-width="1.5"/>
                                <span x-text="course" class="font-medium text-lg truncate text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                            </div>
                            <div class="ms-8">
                        <span
                            x-text="Object.keys(folders[selected.year][selected.semester][selected.version][course]).length +
                                (Object.keys(folders[selected.year][selected.semester][selected.version][course]).length > 1 ? ' itens' : ' item')"
                            class="text-sm text-gray-600 dark:text-gray-400 transition duration-150 ease-in-out">
                        </span>
                            </div>
                        </button>
                    </template>

                    {{-- Mostra os projetos salvos --}}
                    <template
                        x-for="project in (folders[selected.year]?.[selected.semester]?.[selected.version]?.[selected.course]
                            ? Object.keys(folders[selected.year][selected.semester][selected.version][selected.course])
                            : [])"
                        :key="project"
                    >
                        <button
                            x-show="currentLevel === 'course'"
                            type="button"
                            class="flex flex-col p-2 rounded-md gap-x-2 justify-center items-start shadow-sm border border-gray-300
                        hover:cursor-pointer hover:bg-soft-blue hover:shadow-md
                        w-full xs:w-[400px] md:w-auto max-w-full"
                            x-on:click="navigateTo('project',project)"
                        >
                            <div class="inline-flex items-center gap-2 max-w-full overflow-hidden">
                                <x-lucide-folder class="flex-shrink-0 h-6 w-6 text-secondary-blue" stroke-width="1.5"/>
                                <span x-text="'Projeto Integrador ' + project" class="font-medium text-lg truncate text-gray-900 dark:text-gray-100 transition duration-150 ease-in-out"></span>
                            </div>
                            <div class="ms-8">
                                <span
                                    x-text="Object.keys(folders[selected.year][selected.semester][selected.version][selected.course][project]).length +
                                        (Object.keys(folders[selected.year][selected.semester][selected.version][selected.course][project]).length > 1 ? ' itens' : ' item')"
                                    class="text-sm text-gray-600 dark:text-gray-400 transition duration-150 ease-in-out">
                                </span>
                            </div>
                        </button>
                    </template>

                    {{-- Mostra os trabalhos salvos --}}
                    <div class="grid col-span-full gap-2">
                        <template x-if="currentLevel === 'project'">
                            <div class="w-full border border-gray-200 rounded-md">
                                <div class="grid grid-cols-12 me-10 rounded-md p-2 transition duration-150 ease-in-out">
                                    <span class="font-semibold text-left text-gray-700 dark:text-gray-300 transition col-span-12 md:col-span-6 lg:col-span-5 px-4 flex items-center justify-start gap-2">Nome</span>
                                    <span class="font-semibold text-left text-gray-700 dark:text-gray-300 transition col-span-3 px-4 hidden md:flex md:col-span-6 lg:col-span-3 items-center justify-start">Grupo</span>
                                    <span class="font-semibold text-left text-gray-700 dark:text-gray-300 transition col-span-2 px-4 hidden lg:flex lg:col-span-2 items-center justify-start">Avaliação</span>
                                    <span class="font-semibold text-left text-gray-700 dark:text-gray-300 transition col-span-2 px-4 hidden lg:flex lg:col-span-2 items-center justify-start">Status</span>
                                </div>
                            </div>
                        </template>

                        <template
                            x-for="paper in (folders[selected.year]?.[selected.semester]?.[selected.version]?.[selected.course]?.[selected.project] ?? [])"
                            :key="paper.id"
                        >
                            <div class="inline-flex border rounded-md p-2 border-gray-200 dark:border-gray-700 transition duration-150 ease-in-out">
                                <div class="grid grid-cols-12 w-full">
                                    <!-- Colunas do card -->
                                    <div class="col-span-12 md:col-span-6 lg:col-span-5 px-4 flex items-center justify-start gap-2 overflow-hidden">
                                        <x-lucide-file-text class="w-6 h-6 text-gray-600 dark:text-gray-200 flex-shrink-0 transition duration-150 ease-in-out"/>
                                        <span x-text="paper.title"
                                              class="font-medium text-left text-lg text-gray-900 dark:text-gray-200 line-clamp-2 break-all
                                              transition duration-150 ease-in-out"></span>
                                    </div>

                                    <!-- Outras colunas -->
                                    <div class="hidden md:flex md:col-span-6 lg:col-span-3 px-4 items-center justify-start">
                                        <span class="text-gray-900 dark:text-gray-200 text-left line-clamp-2 transition duration-150 ease-in-out" x-text="paper.group_theme"></span>
                                    </div>
                                    <div class="hidden lg:flex lg:col-span-2 px-4  items-center justify-start">
                                        <span class="text-gray-900 dark:text-gray-200 text-left line-clamp-2 transition duration-150 ease-in-out" x-text="paper.version === 'corrected' ? 'Corrigido' : (paper.submitted_at ?? 'Não avaliado')"></span>
                                    </div>
                                    <div class="hidden lg:flex lg:col-span-2 px-4  items-center justify-start" >
                                        <span class="text-gray-900 dark:text-gray-200 text-left line-clamp-2 transition duration-150 ease-in-out">
                                            <template x-if="paper.state">
                                                <template x-if="isInactivating(paper.id)">
                                                    <span>Inativando...</span>
                                                </template>
                                            </template>

                                            <template x-if="!paper.state">
                                                <template x-if="isActivating(paper.id)">
                                                    <span>Ativando...</span>
                                                </template>
                                            </template>
                                            <template x-if="!isActivating(paper.id) && !isInactivating(paper.id)">
                                                <span x-text="paper.state == 1 ? 'Ativo' : 'Inativo'"></span>
                                            </template>
                                        </span>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center">
                                    <x-dropdown direction="up" align="right" width="60" contentClasses="py-1 bg-white dark:bg-gray-700 rounded-md shadow-lg border border-transparent dark:border-gray-900 transition">
                                        <!-- Trigger -->
                                        <x-slot name="trigger">
                                            <button
                                                type="button"
                                                class="flex items-center justify-center rounded-md p-2 hover:bg-gray-200 dark:hover:bg-gray-600/30 transition duration-150 ease-in-out"
                                            >
                                                <x-lucide-ellipsis-vertical class="w-6 h-6 text-gray-600 dark:text-gray-200 transition duration-150 ease-in-out"/>
                                            </button>
                                        </x-slot>

                                        <!-- Conteúdo do dropdown -->
                                        <x-slot name="content">
                                            <div class="px-1 py-5 ">
                                                <hr />

                                                <button
                                                    type="button"
                                                    class="flex items-center w-full rounded-sm px-4 py-2 gap-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition"
                                                    x-on:click="showPaper(paper.file_path)"
                                                >
                                                    <x-lucide-eye class="w-4 h-4 transition"/> Visualizar
                                                </button>

                                                <button
                                                    type="button"
                                                    class="flex items-center w-full rounded-sm px-4 py-2 gap-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition"
                                                    x-on:click="window.open(paper.file_path, '_blank')"
                                                >
                                                    <x-lucide-external-link class="w-4 h-4 transition"/> Nova aba
                                                </button>

                                                <a
                                                    :href="paper.file_path"
                                                    download
                                                    class="flex items-center w-full rounded-sm px-4 py-2 gap-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition"
                                                >
                                                    <x-lucide-download class="w-4 h-4 transition"/> Baixar
                                                </a>

                                                <button
                                                    type="button"
                                                    class="flex items-center w-full rounded-sm px-4 py-2 gap-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition"
                                                    x-on:click="editPaper(paper.id)"
                                                >
                                                    <x-lucide-repeat class="w-4 h-4 transition"/> Alterar
                                                </button>

                                                <button
                                                    type="button"
                                                    class="flex items-center w-full rounded-sm px-4 py-2 gap-2 hover:bg-gray-100 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 transition"
                                                    x-on:click="
                                                        $el.blur();
                                                        warning('confirmação', paper.title, paper.id, paper.state ? 'inativar' : 'ativar');
                                                    "
                                                >
                                                    <span x-show="paper.state == 1" class="flex items-center w-full rounded-sm gap-2 transition">
                                                        <x-lucide-toggle-left class="w-4 h-4 transition"/> Inativar
                                                    </span>
                                                    <span x-show="paper.state != 1" class="flex items-center w-full rounded-sm gap-2 transition">
                                                        <x-lucide-toggle-right class="w-4 h-4 transition"/> Ativar
                                                    </span>
                                                </button>

                                                <hr />
                                            </div>
                                        </x-slot>
                                    </x-dropdown>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
