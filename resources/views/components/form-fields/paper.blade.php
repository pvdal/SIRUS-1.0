<div>
    {{-- Botão estilizado --}}
    <div class="mt-4">
        <label for="pdfFile"
               class="cursor-pointer inline-flex items-center px-4 py-2 bg-secondary-blue hover:opacity-90 mt-1
                text-white text-sm font-medium rounded-md shadow gap-2 transition duration-200 ease-in-out"
        >
            <x-lucide-file class="h-4 w-4 text-white"/>
            <span x-text="edit ? 'Alterar PDF' : 'Escolher PDF'"></span>
        </label>

        {{-- Input real (escondido) --}}
        <input
            id="pdfFile"
            type="file"
            accept="application/pdf"
            class="hidden h-0 w-0"
            x-ref="pdfFile"
            @change="file.file = $event.target.files[0]"
        />

        {{-- Arquivo escolhido --}}
        <template x-if="file.file">
            <div class="mt-4 truncate block flex-1 max-w-full">
                <span class="truncate block flex-1 text-gray-500 mb-1">
                    <span class="font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out">Arquivo selecionado (limite: 5MB):</span>
                </span>
                <div class="flex flex-col bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-900/70 p-2 rounded">
                    <div class="block xs:flex items-center">
                        <span class="ms-1 flex flex-row items-center space-x-2 overflow-hidden w-full pe-4 py-2">
                            <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0"/>
                            <template x-if="file.file && file.url">
                                <span
                                    class="text-primary-blue dark:text-gray-200 truncate text-ellipsis"
                                    x-text="file.title"
                                    :title="file.title"
                                ></span>
                            </template>
                        </span>
                        <button
                            class="flex justify-center items-center pr-4 min-w-[127px] whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                               text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:!bg-gray-700
                               cursor-pointer"
                            x-on:click="window.open(file.url, '_blank'); $el.blur();"
                        >
                            Visualizar
                        </button>
                    </div>
                    <hr class="mt-2"/>
                    <template x-if="file.file && file.url">
                        <div class="ms-2 xs:ms-7">
                            <span class="truncate overflow-hidden w-full flex-1 text-gray-500 dark:text-gray-200">
                                <span class="block truncate text-ellipsis" x-text="'Tamanho do arquivo: ' + '(' + (file.file.size / (1024 * 1024)).toFixed(2) + ' MB)'"></span>
                            </span>
                        </div>
                    </template>
                </div>
            </div>
        </template>
        <template x-if="errors.file">
            <x-form-fields.field-error x-text="errors.file[0]"/>
        </template>
    </div>

    {{-- Arquivo salvo --}}
    <template x-if="edit && file_path">
        <div class="mt-4 truncate block flex-1 max-w-full">
            <span class="truncate block flex-1 text-gray-500 mb-1">
                <span class="font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out">Arquivo salvo</span>
            </span>
            <div class="flex flex-col bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-900/70 p-2 rounded">
                <div class="block xs:flex items-center">
                    <span class="ms-1 flex flex-row items-center space-x-2 overflow-hidden w-full pe-4 py-2">
                        <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0"/>
                        <template x-if="title && file_path">
                            <span
                                class="text-primary-blue dark:text-gray-200 truncate text-ellipsis"
                                x-text="title"
                                :title="title"
                            ></span>
                        </template>
                    </span>
                    <button
                        class="flex justify-center items-center pr-4 min-w-[127px] whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                               text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 bg-white dark:!bg-gray-700
                               cursor-pointer"
                        x-on:click="showPaper(file_path); $el.blur();"
                    >
                        Visualizar
                    </button>
                </div>
                <hr class="mt-2"/>
                <div class="ms-2 xs:ms-7">
                    <span class="truncate overflow-hidden w-full flex-1 text-gray-500 dark:text-gray-200">
                        <span class="block truncate text-ellipsis" x-text="'Tamanho do arquivo: ' + formatFileSize(file_size)"></span>
                    </span>
                </div>
            </div>
        </div>
    </template>

    {{-- Título do novo trabalho --}}
    <template x-if="file.file">
        <div class="mt-4">
            <x-label for="title" value="Título do novo trabalho"/>
            <x-input id="title" type="text" autocomplete="name" class="w-full mt-1"
                     placeholder="Título do novo trabalho" x-model="newPaperTitle"
                     @keydown.enter="savePaper"
                     x-bind:disabled="!file.file && !edit"/>
            <template x-if="errors.title">
                <x-form-fields.field-error x-text="errors.title[0]"/>
            </template>
        </div>
    </template>

    {{-- Título do trabalho --}}
    <template x-if="!file.file">
        <div class="mt-4">
            <x-label for="title" value="Título do trabalho"/>
            <x-input id="title" type="text" autocomplete="name" class="w-full mt-1"
                     placeholder="Título do trabalho" x-model="title"
                     @keydown.enter="savePaper"
                     x-bind:disabled="!file.file && !edit"/>
            <template x-if="errors.title">
                <x-form-fields.field-error x-text="errors.title[0]"/>
            </template>
        </div>
    </template>

    <div class="mt-4">
        <x-label for="year">Ano</x-label>
        <x-select id="year" x-model="year" class="mt-1 w-full">
            <option value="">Selecione um ano</option>
            @php
                $currentYear = date('Y');
            @endphp
            @for($i = 2024; $i< ($currentYear + 1); $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </x-select>
        <template x-if="errors.year">
            <x-form-fields.field-error x-text="errors.year[0]"/>
        </template>
    </div>

    <div class="mt-4">
        <x-label for="semester">Semestre</x-label>
        <x-select id="semester" x-model="semester" class="mt-1 w-full">
            <option value="">Selecione um semestre</option>
            @for($i = 1; $i<3; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </x-select>
        <template x-if="errors.semester">
            <x-form-fields.field-error x-text="errors.semester[0]"/>
        </template>
    </div>
    {{--
    <div class="mt-4">
        <x-label for="version">Versão</x-label>
        <x-select id="version" x-model="version" class="mt-1 w-full">
            <option value="">Selecione uma versão</option>
            <option value="evaluation">Avaliação</option>
            <option value="corrected">Corrigida</option>
        </x-select>
        <template x-if="errors.version">
            <x-form-fields.field-error x-text="errors.version[0]"/>
        </template>
    </div>

    <template x-if="version === 'corrected' && group_id">
        <div class="mt-4">
            <x-label for="evaluation-version">Versão avaliada (opcional)</x-label>
            <x-select id="evaluation-version" x-model.number="evaluation_paper_id" class="mt-1 w-full" x-bind:disabled="version !== 'corrected'">
                <option value="">Selecione uma versão</option>
                <template x-for="paper in evaluation_papers">
                    <option :value="paper.id" x-text="paper.title"></option>
                </template>
            </x-select>
            <template x-if="errors.evaluation_paper_id">
                <x-form-fields.field-error x-text="errors.evaluation_paper_id[0]"/>
            </template>
        </div>
    </template>

    <template x-if="version === 'evaluation' && submitted_at">
        <div class="mt-4">
            <x-label for="corrected-version">Versão Corrigida (opcional)</x-label>
            <x-select id="corrected-version" x-model.number="corrected_paper_id" class="mt-1 w-full" x-bind:disabled="version !== 'evaluation'">
                <option value="">Selecione uma versão</option>
                <template x-for="paper in corrected_papers">
                    <option :value="paper.id" x-text="paper.title"></option>
                </template>
            </x-select>
            <template x-if="errors.corrected_paper_id">
                <x-form-fields.field-error x-text="errors.corrected_paper_id[0]"/>
            </template>
        </div>
    </template>
    --}}
    <div class="mt-4">
        <x-label for="course">Curso</x-label>
        <x-select id="course" x-model="course_id" class="mt-1 w-full">
            <option value="">Selecione um curso</option>
            <template x-for="course in courses">
                <option :value="course.id" x-text="course.name"></option>
            </template>
        </x-select>
        <template x-if="errors.course_id">
            <x-form-fields.field-error x-text="errors.course_id[0]"/>
        </template>
    </div>

    <div class="mt-4">
        <x-label for="project">Projeto</x-label>
        <x-select id="project" x-model="project" class="mt-1 w-full">
            <option value="">Selecione um projeto</option>
            @for($i = 1; $i<7; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </x-select>
        <template x-if="errors.project">
            <x-form-fields.field-error x-text="errors.project[0]"/>
        </template>
    </div>
    {{--
    <div class="mt-4">
        <x-label for="group_id" value="Grupo do trabalho"/>
        <x-select id="group_id" x-model="group_id" class="mt-1 w-full">
            <option value="">Selecione um grupo</option>
            <template x-for="group in groups">
                <option :value="group.id" x-text="group.theme"></option>
            </template>
        </x-select>
        <template x-if="errors.group_id">
            <x-form-fields.field-error x-text="errors.group_id[0]"/>
        </template>
    </div>
    --}}
    <div class="mt-4 block w-full me-1 xs:me-2">
        <legend
            class="block font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out"
        >Grupo do trabalho</legend>
        <button @click="group.drop = !group.drop"
                class="mt-1 flex justify-between items-center pr-4 w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 dark:border-gray-400 rounded-lg
                                           text-left px-4 py-2.5 xs:me-2 mb-2 text-base text-gray-700 dark:text-gray-100 focus:ring-1 focus:ring-secondary-blue
                                           focus:border-secondary-blue cursor-pointer transition"
                x-bind:disabled="loading"
                :title="group.theme || 'Selecione um grupo'">
            <span class="truncate" x-text="group.theme || 'Selecione um grupo'"></span>
            <x-lucide-chevron-down class="w-4 h-4 text-gray-700 dark:text-gray-100 flex-shrink-0 ms-auto transition"/>
        </button>

        <ul x-show="group.drop"
            @click.outside="group.drop = false"
            class="w-full border bg-gray-200/50 dark:bg-gray-700 mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom transition duration-150 ease-in-out">
            <li class="flex items-center m-1 mx-2">
                <x-lucide-search class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 transition"/>
                <input
                    type="search"
                    class="bg-transparent w-full py-1 px-2 border-transparent focus:outline-none focus:ring-0 focus:border-transparent
                                                text-gray-700 dark:text-gray-100"
                    placeholder="Buscar grupo..."
                    x-model="group.search"
                />
            </li>

            <template x-if="searching">
                <li class="px-4 py-2 text-base text-gray-500 break-words rounded-sm transition duration-150 ease-in-out">Buscando...</li>
            </template>
            <template x-if="!groups.length && group.search && !searching && showNoGroupsMsg">
                <li class="px-4 py-2 text-base text-gray-500 break-words rounded-sm transition duration-150 ease-in-out">Nenhum grupo encontrado.</li>
            </template>

            <div x-show="groups.length > 0">
                <template x-for="item in groups" :key="item.id">
                    <li @click="group.id = item.id; group.theme = item.theme; group.drop = false"
                        class="border-t border-gray-300 px-4 py-2 text-base text-gray-700 dark:text-gray-100 break-words cursor-pointer rounded-sm transition duration-150 ease-in-out
                            hover:bg-gray-200/50 dark:hover:bg-gray-600
                        "
                        x-text="item.theme">
                    </li>
                </template>
            </div>
        </ul>
        <template x-if="errors.group_id">
            <x-form-fields.field-error x-text="errors.group_id[0]"/>
        </template>
    </div>


    <template x-if="!corrected_version">
        <div class="mt-4">
            <template x-if="schedule.start && schedule.end && edit">
                <div class="flex flex-col xs:flex-row gap-4 items-start justify-center text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out">
                    <div class="w-full xs:w-1/2">
                        <span class="block font-medium text-sm">Início da avaliação</span>
                        <x-input class="font-normal text-sm w-full mt-1" x-model="schedule.start" readonly disabled/>
                    </div>
                    <div class="w-full xs:w-1/2">
                        <span class="block font-medium text-sm">Fim da avaliação</span>
                        <x-input class="font-normal text-sm w-full mt-1" x-model="schedule.end" readonly disabled/>
                    </div>
                </div>
            </template>
        </div>
    </template>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
