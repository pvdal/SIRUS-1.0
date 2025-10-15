<div>
    <div class="mt-4">
        <x-label for="theme" value="Tema do grupo"/>
        <x-input id="theme" type="text" autocomplete="name" class="w-full mt-1"
                placeholder="Tema do grupo" x-model="theme"
                @keydown.enter="saveGroup"/>
        <template x-if="errors.theme">
            <x-form-fields.field-error x-text="errors.theme[0]"/>
        </template>
    </div>

    <div class="mt-4">
        <x-label for="pdfFile" value="Atribuir trabalho do grupo (opcional)"></x-label>
        <div id="fileArea" class="space-y-2">
            {{-- Botão estilizado --}}
            <label for="pdfFile"
                class="cursor-pointer inline-flex items-center px-4 py-2 bg-secondary-blue hover:opacity-90 mt-1
                text-white text-sm font-medium rounded-md shadow gap-2 transition duration-200 ease-in-out"
            >
                <x-lucide-file class="h-4 w-4 text-white"/>
                Escolher PDF
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
                <div class="truncate block flex-1 max-w-full">
                    <span class="truncate block flex-1 text-gray-500 mb-1">
                        <span class="font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out">Arquivo selecionado (limite: 5MB):</span>
                    </span>
                    <div class="flex flex-col bg-gray-100 dark:bg-gray-700 hover:bg-gray-100/60 dark:hover:bg-gray-600/50 p-2 rounded">
                        <div class="flex items-center mb-2">
                            <span class="ms-1 flex flex-row items-center space-x-2 max-w-[85%] xs:max-w-[90%] overflow-hidden">
                                <button
                                    class="text-blue-500 dark:text-gray-200 hover:text-blue-700 h-[100%] rounded-sm bg-blue-100 dark:bg-secondary-blue p-[0.125rem]"
                                    @click="addPaper()"
                                    :title="'Adicionar'"
                                >
                                    <x-lucide-plus class="w-6 h-6 text-blue-600 dark:text-gray-200 flex-shrink-0"/>
                                </button>

                                <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0"/>
                                <template x-if="file.file && file.url">
                                    <span
                                        class="text-primary-blue dark:text-gray-200 truncate text-ellipsis"
                                        x-text="file.title"
                                        :title="file.title"
                                    ></span>
                                </template>
                            </span>
                        </div>

                        {{-- Conteúdo expandido --}}
                        <div class="flex flex-wrap justify-center md:justify-start gap-5 px-6 py-4 md:px-14 pb-2 bg-gray-50 dark:bg-gray-600/50">
                            <div>
                                <x-label>Ano</x-label>
                                <x-select x-model="file.year" class="mt-1 w-32 dark:!bg-gray-700">
                                    @php
                                        $currentYear = date('Y');
                                    @endphp
                                    @for($i = $currentYear - 1; $i<($currentYear + 1); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </x-select>
                            </div>

                            <div>
                                <x-label>Semestre</x-label>
                                <x-select x-model="file.semester" class="mt-1 w-32 dark:!bg-gray-700">
                                    @for($i = 1; $i<3; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </x-select>
                            </div>

                            <div>
                                <x-label>Projeto</x-label>
                                <x-select x-model="file.project" class="mt-1 w-32 dark:!bg-gray-700">
                                    @for($i = 1; $i<7; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </x-select>
                            </div>

                            <div>
                                <x-label>Versão</x-label>
                                <x-select x-model="file.version" class="mt-1 w-32 dark:!bg-gray-700">
                                    <option value="evaluation">Avaliação</option>
                                    <option value="corrected">Corrigida</option>
                                </x-select>
                            </div>

                            <div>
                                <x-label>Curso</x-label>
                                <x-select x-model="file.course" class="mt-1 w-32 dark:!bg-gray-700 sm:w-[277px] md:w-[425px]">
                                    <option value="">Selecione um curso</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course['id'] }}">{{ $course['name'] ?? '-' }}</option>
                                    @endforeach
                                </x-select>
                            </div>

                            <div class="flex items-center mt-auto">
                                <template x-if="file.file && file.url">
                                    <button
                                        class="flex justify-center items-center pr-4 min-w-[127px] whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                                               text-left px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-secondary-blue bg-white dark:!bg-gray-700
                                               focus:border-secondary-blue cursor-pointer mt-auto"
                                        x-on:click="window.open(file.url, '_blank'); $el.blur();"
                                    >
                                        Visualizar
                                    </button>
                                </template>
                            </div>
                        </div>

                        <template x-if="file.file && file.url">
                            <div class="ms-2">
                                <span class="truncate block flex-1 text-gray-500 dark:text-gray-200">
                                    <span class="flex" x-text="'Tamanho do arquivo: ' + '(' + (file.file.size / (1024 * 1024)).toFixed(2) + ' MB)'"></span>
                                </span>
                            </div>
                        </template>
                    </div>
                </div>
            </template>

            {{-- Mostra os trabalhos que o grupo já tem --}}
            <template x-if="papers.length > 0">
                <div class="flex flex-col justify-center space-y-1">
                    <h4 class="font-semibold mt-2">Trabalhos do grupo:</h4>
                    <button
                        type="button"
                        class="max-w-[140px] cursor-pointer inline-flex items-center px-4 py-2 bg-primary-orange hover:opacity-90
                        text-white text-sm font-medium rounded-md shadow gap-2 transition duration-200 ease-in-out justify-center me-auto"
                        x-on:click="dropAll(); $el.blur();"
                    >Fechar todos</button>
                    {{-- Lista com os trabalhos do grupo --}}
                    <ul class="space-y-1 mt-2">
                        {{-- É importante que haja a interação do index para que a exibição de erros ocorra com êxito --}}
                        <template x-for="(paper,index) in papers" :key="paper.id ?? paper.tempId">
                            <li
                                :class="{
                                    'flex flex-col bg-gray-100 dark:bg-gray-700 p-2 rounded': true,
                                    'hover:bg-gray-100/60 dark:hover:bg-gray-600/50': paper.state !== 0,
                                }"
                            >
                                {{-- Controle dos elementos paper --}}
                                <div
                                    :class="{
                                        'flex items-center justify-between transition duration-150 ease-in-out': true,
                                        'cursor-pointer': paper.state !== 0,
                                        'cursor-default opacity-50': paper.state === 0,
                                        'pb-2': paperExpanded[paper.id ?? paper.tempId]
                                    }"
                                    @click="paperExpanded[paper.id ?? paper.tempId] = !paperExpanded[paper.id ?? paper.tempId]"
                                    :title="paper.title"
                                >
                                    <span class="ms-1 flex flex-row space-x-2 max-w-[85%] xs:max-w-[90%] overflow-hidden">
                                        <x-lucide-chevron-right
                                            class="w-4 h-4  flex-shrink-0 transition-transform duration-200"
                                            x-bind:class="{
                                                'rotate-90': paperExpanded[paper.id ?? paper.tempId],
                                                'opacity-0': paper.state === 0,
                                                'text-gray-600 dark:text-gray-200': paper.state
                                            }"
                                        />
                                        <x-lucide-file-text class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0"/>
                                        <span
                                            :class="{
                                                'text-primary-blue dark:text-gray-200 truncate text-ellipsis': true,
                                                'line-through': !paper.state && paper.id !== null
                                            }"
                                            x-text="paper.title"
                                            :title="paper.title"
                                        ></span>
                                    </span>
                                    <x-form-fields.remove-button class="ms-5" x-show="paper.state !== 0" :action="'removePaper'" :key="'(paper.id ?? paper.tempId)'"/>
                                    <template x-if="paper.state === 0">
                                        <span class="ms-5" x-text="'(Inativo)'"></span>
                                    </template>
                                </div>

                                {{-- Conteúdo expandido --}}
                                <div
                                    x-show="paperExpanded[paper.id ?? paper.tempId] && paper.state !== 0"
                                    class="flex flex-wrap justify-center md:justify-start overflow-hidden gap-5 px-6 py-4 md:px-14 pb-2 bg-gray-50 dark:bg-gray-600/50"
                                >
                                    <div>
                                        <x-label>Projeto</x-label>
                                        <x-input x-model="paper.title" type="text" class="mt-1 w-32 dark:!bg-gray-700 sm:w-[277px] md:w-[572px] truncate"/>
                                    </div>
                                    <div>
                                        <x-label>Ano</x-label>
                                        <x-select x-model="paper.year" class="mt-1 w-32 dark:!bg-gray-700">
                                            @for($i = $currentYear -1; $i< ($currentYear + 1); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </x-select>
                                    </div>

                                    <div>
                                        <x-label>Semestre</x-label>
                                        <x-select x-model="paper.semester" class="mt-1 w-32 dark:!bg-gray-700">
                                            @for($i = 1; $i<3; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </x-select>
                                    </div>

                                    <div>
                                        <x-label>Projeto</x-label>
                                        <x-select x-model="paper.project" class="mt-1 w-32 dark:!bg-gray-700">
                                            @for($i = 1; $i<7; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </x-select>
                                    </div>

                                    <div>
                                        <x-label>Versão</x-label>
                                        <x-select x-model="paper.version" class="mt-1 w-32 dark:!bg-gray-700">
                                            <option value="evaluation">Avaliação</option>
                                            <option value="corrected">Corrigida</option>
                                        </x-select>
                                    </div>

                                    <div>
                                        <x-label>Curso</x-label>
                                        <x-select x-model="paper.course" class="mt-1 w-32 dark:!bg-gray-700 sm:w-[277px] md:w-[425px]">
                                            <option value="">Selecione um curso</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course['id'] }}" title="{{ $course['name'] }}">{{ $course['name'] ?? '-' }}</option>
                                            @endforeach
                                        </x-select>
                                    </div>

                                    <div class="flex items-center mt-auto">
                                        <button
                                            class="flex justify-center items-center pr-4 min-w-[127px] whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                                           text-left px-4 py-2.5 text-sm text-gray-700 dark:text-gray-200 focus:ring-1 focus:ring-secondary-blue bg-white dark:!bg-gray-700
                                           focus:border-secondary-blue cursor-pointer mt-auto"
                                            x-on:click="paper.file_path ? showPaper(`${paper.file_path}`) : window.open(paper.url, '_blank')"
                                        >
                                            Visualizar
                                        </button>
                                    </div>
                                </div>

                                {{-- Se o paper não tem ID, tem tempId, isso significa que ainda não está no banco, e é marcado como pendente--}}
                                <template x-if="!paper.id">
                                    <span
                                        class="text-xs py-1 ms-7 mt-2 px-3 font-bold text-white text-center rounded-s-lg rounded-e-lg bg-secondary-blue max-w-20"
                                        x-text="'Pendente'"
                                    ></span>
                                </template>

                                {{-- Validações de erro de cada campo do menu accordion --}}
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.title']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.title']?.[0]"/>
                                </template>
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.file']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.file']?.[0]"/>
                                </template>
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.year']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.year']?.[0]"/>
                                </template>
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.semester']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.semester']?.[0]"/>
                                </template>
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.project']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.project']?.[0]"/>
                                </template>
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.version']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.version']?.[0]"/>
                                </template>
                                <template x-if="papers.length > 0 && errors && errors['papers.' + index + '.course']">
                                    <x-form-fields.field-error
                                       x-text="errors['papers.' + index + '.course']?.[0]"/>
                                </template>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
        <template x-if="errors.papers">
            <x-form-fields.field-error x-text="errors.papers[0]"/>
        </template>
    </div>

    {{--
     --- INCLUIR ANULOS
     --}}

    {{-- Campo de busca --}}
    <div class="mt-4">
        <x-label for="searchStudent" value="Busque os membros do grupo" class="mt-8"/>
        <x-input id="searchStudent" type="search" autocomplete="off" class="w-full mt-1"
                placeholder="Buscar aluno por nome ou RA..." x-model="searchStudent"
                @keydown.enter="saveGroup"/>
        <template x-if="errors.members">
            <x-form-fields.field-error x-text="errors.members[0]"/>
        </template>
    </div>
    {{-- Lista de sugestões --}}
    <template x-if="!filteredStudents.length && searchStudent && !searching && showNoStudentsMsg">
        <p class="p-2 text-gray-500">Nenhum aluno encontrado.</p>
    </template>
    <ul
        x-show="filteredStudents.length > 0 || searching" class="max-h-80 overflow-y-auto scrollbar-custom"
        x-bind:class="{ 'border rounded bg-gray-100 dark:bg-gray-700 shadow-sm dark:shadow-gray-700': filteredStudents.length > 0}"
    >
        <template x-if="searching">
            <li class="p-2 text-gray-500">Buscando...</li>
        </template>

        <template x-for="student in filteredStudents" :key="student.ra">
            <li
                class="p-2 border-b border-gray-300"
                @click="!student.group && addMember(student)"
                :class="{ 'opacity-50 cursor-normal': student.group, 'cursor-pointer hover:bg-gray-200/50 dark:hover:bg-gray-600': !student.group }"
            >
                <div>
                    <span x-text="student.name + ': ' + student.ra"></span>
                </div>
                <template x-if="student.group">
                    <div>
                        <span x-text="'Grupo: ' + student.group"></span>
                    </div>
                </template>
            </li>
        </template>
    </ul>

    {{-- Alunos adicionados --}}
    <x-form-fields.selected-list
        :title="'Alunos selecionados:'"
        :list="'members'"
        :key="'ra'"
    >
        <span class="ms-1 flex flex-wrap overflow-hidden max-w-[90%]">
            {{-- Nome com truncamento --}}
            <span class="truncate block xs:whitespace-normal max-w-full" x-text="item.name"></span>

            {{-- Hífen + RA sempre juntos --}}
            <span class="truncate">
                <span class="whitespace-nowrap ml-1" x-text="'- ' + item.ra"></span>
            </span>
        </span>
        <x-form-fields.remove-button class="ms-5" :action="'removeMember'" :key="'item.ra'"/>
    </x-form-fields.selected-list>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
