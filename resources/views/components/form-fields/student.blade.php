<div>
    {{-- RA do aluno --}}
    <div class="mt-4">
        <x-label for="ra" value="RA do Aluno"/>
        <x-input id="ra"
                 type="text"
                 autocomplete="text"
                 class="w-full"
                 @input="ra = ra.replace(/\D/g,'')"
                 placeholder="RA do aluno"
                 x-model="ra" x-bind:disabled="edit"
                 @keydown.enter="saveStudent"/>
        <template x-if="errors.ra">
            <x-form-fields.field-error x-text="errors.ra[0]"/>
        </template>
    </div>
    {{-- Nome do aluno --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Aluno"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full mt-1"
                 placeholder="Nome do aluno" x-model="name"
                 @keydown.enter="saveStudent"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>
    {{-- Email do aluno --}}
    <div class="mt-4">
        <x-label for="email" value="Email do Aluno"/>
        <x-input id="email" type="text" autocomplete="email" class="w-full mt-1"
                 placeholder="E-mail do aluno" x-model="email"
                 @keydown.enter="saveStudent"/>
        <template x-if="errors.email">
            <x-form-fields.field-error x-text="errors.email[0]"/>
        </template>
    </div>
    {{-- Grupo --}}
    <div class="mt-4 block w-full me-1 xs:me-2">
        <legend
            class="block font-medium text-sm text-gray-700 dark:text-gray-300 transition duration-150 ease-in-out"
        >Grupo (opcional)</legend>
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

    {{-- Curso --}}
    <div class="mt-4">
        <x-label for="course_id" value="Curso (opcional)"/>
        <x-select id="course_id" x-model="course_id" class="w-full mt-1">
            <option value="" selected>Selecione um curso</option>
            <template x-for="course in courses" :key="course.id">
                <option :value="course.id" x-text="course.name ?? '-'"></option>
            </template>
        </x-select>
        <template x-if="errors.course_id">
            <x-form-fields.field-error x-text="errors.course_id[0]"/>
        </template>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
