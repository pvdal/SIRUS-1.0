<div class="space-y-2">
    <div class="mt-4">
        <x-label for="theme" value="Tema do grupo"/>
        <x-input id="theme" type="text" autocomplete="name" class="w-full"
                placeholder="Tema do grupo" x-model="theme"
                @keydown.enter="saveGroup"/>
        <template x-if="errors.theme">
            <p class="text-red-600 text-sm" x-text="errors.theme[0]"></p>
        </template>
    </div>

    <div class="mt-4">
        <x-label for="pdfFile" value="Atribuir trabalho do grupo"></x-label>
        <div id="fileArea" class="space-y-2">
            {{-- Botão estilizado --}}
            <label for="pdfFile"
                class="cursor-pointer inline-flex items-center px-4 py-2 bg-secondary-blue hover:opacity-90
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
                class="hidden"
                x-ref="pdfFile"
                @change="file.file = $event.target.files[0]"
            />

            {{-- Arquivo escolhido --}}
            <template x-if="file.file">
                <div class="truncate block flex-1 max-w-full">
                    <span class="truncate block flex-1 text-gray-500">
                        <span class="text-gray-800">Arquivo selecionado (limite: 10MB):</span>
                    </span>
                    <div class="flex flex-col bg-gray-100 hover:bg-gray-200/60 p-2 rounded">
                        <div class="flex items-center mb-2">
                            <span class="ms-1 flex flex-row items-center space-x-2 max-w-[85%] xs:max-w-[90%] overflow-hidden">
                                <button
                                    class="text-blue-500 hover:text-blue-700 h-[100%] rounded-sm bg-blue-100"
                                    @click="addPaper()"
                                    :title="'Adicionar'"
                                >
                                    <x-lucide-plus class="w-6 h-6 text-blue-600 flex-shrink-0"/>
                                </button>

                                <x-lucide-file-text class="w-4 h-4 text-gray-600 flex-shrink-0"/>
                                <template x-if="file.file && file.url">
                                    <span
                                        class="text-primary-blue truncate text-ellipsis"
                                        x-text="file.title"
                                        :title="file.title"
                                    ></span>
                                </template>
                            </span>
                        </div>

                        {{-- Conteúdo expandido --}}
                        <div class="flex flex-wrap justify-start gap-5 px-6 md:px-14 pb-2 bg-gray-50">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ano</label>
                                <select x-model="file.year" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                    @php
                                        $currentYear = date('Y');
                                    @endphp
                                    @for($i = $currentYear - 2; $i<($currentYear + 2); $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Semestre</label>
                                <select x-model="file.semester" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                    @for($i = 1; $i<3; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Projeto</label>
                                <select x-model="file.project" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                    @for($i = 1; $i<7; $i++)
                                        <option value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Versão</label>
                                <select x-model="file.version" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                    <option value="evaluation">Avaliação</option>
                                    <option value="corrected">Corrigida</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Curso</label>
                                <select x-model="file.course" class="mt-1 block w-32 sm:w-auto sm:max-w-[277px] rounded truncate border-gray-300 shadow-sm">
                                    <option value="">Selecione um curso</option>
                                    @foreach($courses as $course)
                                        <option value="{{ $course['id'] }}">{{ $course['name'] ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="flex items-center mt-auto">
                                <template x-if="file.file && file.url">
                                    <button
                                        class="flex justify-center items-center pr-4 min-w-[127px] whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                                               text-left px-4 py-2.5 text-sm text-gray-700 focus:ring-1 focus:ring-secondary-blue
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
                                <span class="truncate block flex-1 text-gray-500">
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
                    <h4 class="font-semibold mt-4">Trabalhos do grupo:</h4>
                    <button
                        type="button"
                        class="max-w-[140px] cursor-pointer inline-flex items-center px-4 py-2 bg-primary-orange hover:opacity-90
                        text-white text-sm font-medium rounded-md shadow gap-2 transition duration-200 ease-in-out justify-center me-auto"
                        x-on:click="dropAll(); $el.blur();"
                    >Fechar todos</button>
                    <ul class="space-y-1 mt-2">
                        <template x-for="paper in papers" :key="paper.id ?? paper.tempId">
                            <li
                                class="flex flex-col bg-gray-100 hover:bg-gray-200/60 p-2 rounded"
                            >
                                <div
                                    class="flex items-center justify-between cursor-pointer"
                                    @click="paperExpanded[paper.id ?? paper.tempId] = !paperExpanded[paper.id ?? paper.tempId]"
                                >
                                    <span class="ms-1 flex flex-row space-x-2 max-w-[85%] xs:max-w-[90%] overflow-hidden">
                                        <x-lucide-chevron-right
                                            class="w-4 h-4 text-gray-600 flex-shrink-0 transition-transform duration-200"
                                            x-bind:class="paperExpanded[paper.id] ? 'rotate-90' : ''"
                                        />
                                        <x-lucide-file-text class="w-4 h-4 text-gray-600 flex-shrink-0"/>
                                        <span
                                            class="text-primary-blue cursor-pointer truncate  text-ellipsis"
                                            x-text="paper.title"
                                            :title="paper.title"
                                        ></span>
                                    </span>
                                    <button
                                        class="text-red-500 hover:text-red-700 h-[100%] w-[20px] rounded-sm bg-red-100"
                                        @click.stop="removePaper(paper.id ?? paper.tempId)"
                                        :title="'Remover'"
                                    >
                                        ✕
                                    </button>
                                </div>

                                {{-- Conteúdo expandido --}}
                                <div
                                    x-show="paperExpanded[paper.id ?? paper.tempId]"
                                    x-transition
                                    class="flex flex-wrap justify-start gap-5 px-6 md:px-14 pb-2 bg-gray-50"
                                >
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Ano</label>
                                        <select x-model="paper.year" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                            @for($i = $currentYear -2; $i< ($currentYear + 2); $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Semestre</label>
                                        <select x-model="paper.semester" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                            @for($i = 1; $i<3; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Projeto</label>
                                        <select x-model="paper.project" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                            @for($i = 1; $i<7; $i++)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Versão</label>
                                        <select x-model="paper.version" class="mt-1 block w-32 rounded border-gray-300 shadow-sm">
                                            <option value="evaluation">Avaliação</option>
                                            <option value="corrected">Corrigida</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Curso</label>
                                        <select x-model="paper.course" class="mt-1 block w-32 sm:w-auto sm:max-w-[277px] rounded truncate border-gray-300 shadow-sm">
                                            <option value="">Selecione um curso</option>
                                            @foreach($courses as $course)
                                                <option value="{{ $course['id'] }}">{{ $course['name'] ?? '-' }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="flex items-center mt-auto">
                                        <button
                                            class="flex justify-center items-center pr-4 min-w-[127px] whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                                           text-left px-4 py-2.5 text-sm text-gray-700 focus:ring-1 focus:ring-secondary-blue
                                           focus:border-secondary-blue cursor-pointer mt-auto"
                                            x-on:click="paper.file_path ? showPaper(`/${paper.file_path}`) : window.open(paper.url, '_blank')"
                                        >
                                            Visualizar
                                        </button>
                                    </div>
                                </div>

                                <template x-if="!paper.id">
                                    <span
                                        class="text-xs py-1 ms-7 mt-2 px-3 font-bold text-white text-center rounded-s-lg rounded-e-lg bg-secondary-blue max-w-20"
                                        x-text="'Pendente'"
                                    ></span>
                                </template>
                            </li>
                        </template>
                    </ul>
                </div>
            </template>
        </div>
        <template x-if="errors.file">
            <p class="text-red-600 text-sm" x-text="errors.file[0]"></p>
        </template>
    </div>

    {{-- INCLUIR ANULOS --}}
    {{-- Campo de busca --}}
    <div class="mt-4">
        <x-label for="searchStudent" value="Busque os membros do grupo" class="mt-8"/>
        <x-input id="searchStudent" type="search" autocomplete="off" class="w-full"
                placeholder="Buscar aluno por nome ou RA..." x-model="searchStudent"
                @keydown.enter="saveGroup"/>
        <template x-if="errors.members">
            <p class="text-red-600 text-sm" x-text="errors.members[0]"></p>
        </template>
    </div>
    {{-- Lista de sugestões --}}
    <template x-if="!filteredStudents.length && searchStudent && !searching && showNoStudentsMsg">
        <p class="p-2 text-gray-500">Nenhum aluno encontrado.</p>
    </template>
    <ul x-show="filteredStudents.length > 0 || searching" class="max-h-60 overflow-y-auto scrollbar-custom"
        x-bind:class="{ 'border rounded bg-gray-50 drop-shadow-sm': filteredStudents.length > 0}"
    >
        <template x-if="searching">
            <li class="p-2 text-gray-500">Buscando...</li>
        </template>

        <template x-for="student in filteredStudents" :key="student.ra">
            <li
                class="p-2 border-b"
                @click="!student.group && addMember(student)"
                :class="{ 'opacity-50 cursor-normal': student.group, 'cursor-pointer hover:bg-blue-100': !student.group }"
            >
                <div>
                    <span x-text="student.name + ': '"></span>
                    <span x-text="student.ra"></span>
                </div>
                <template x-if="student.group">
                    <div>
                        <span x-text="'Grupo: ' +student.group"></span>
                    </div>
                </template>
            </li>
        </template>
    </ul>

    {{-- Alunos adicionados --}}
    <div x-show="members.length > 0" class="mt-4">
        <h4 class="font-semibold">Alunos selecionados:</h4>
        <ul class="space-y-1 mt-2">
            <template x-for="member in members" :key="member.ra">
                <li class="flex items-center justify-between bg-gray-100 p-2 rounded">
                <span>
                    <span x-text="member.name"></span> -
                    <span x-text="member.ra"></span>
                </span>
                    <button
                        class="text-red-500 hover:text-red-700 h-[100%] w-[20px] rounded-sm bg-red-100"
                        @click="removeMember(member.ra)"
                        title="Remover"
                    >
                        ✕
                    </button>
                </li>
            </template>
        </ul>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <div class="mt-5">
            <p class="text-sm text-gray-800" x-text="created_at"></p>
            <p class="text-sm text-gray-800" x-text="updated_at"></p>
        </div>
    </template>
</div>
