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
        <x-label for="pdfFile" value="Trabalho do aluno"></x-label>
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
                @change="file = $event.target.files[0]"
            />

            {{-- Nome do arquivo escolhido --}}
            <template x-if="file">
                <div class="truncate block flex-1 max-w-full">
                    <span class="truncate block flex-1 text-gray-500">
                        <span class="text-gray-700">Arquivo selecionado (limite: 10MB):</span>
                    </span>
                    <template x-if="!(file instanceof File) && file.url">
                        <span class="ms-2">
                            <a :href="file.url" target="_blank" class="text-blue-500 underline" x-text="file.name">baixar</a>
                            <span class="ml-2 text-gray-500">salvo ✓</span>
                        </span>
                    </template>

                    <template x-if="file instanceof File && fileObjectUrl">
                        <span class="ms-2">
                            <a :href="fileObjectUrl" download="arquivo.pdf" class="text-blue-500 underline" x-text="file.name">baixar</a>
                            <span class="truncate block flex-1 ml-2 text-gray-500">
                                <span class="flex" x-text="'Tamanho do arquivo: ' + '(' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)'"></span>
                            </span>
                        </span>
                    </template>
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
        <x-label for="searchStudent" value="Busque os membros do grupo"/>
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
                        class="text-red-500 hover:text-red-700"
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
