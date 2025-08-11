<div>
    {{-- RA do aluno --}}
    <div class="mt-4">
        <x-label for="ra" value="RA do Aluno"/>
        <x-input id="ra" type="number" autocomplete="ra" class="w-full" onkeydown="return ['e','E','+','-'].indexOf(event.key) === -1"
                 placeholder="RA do aluno" x-model="ra" x-bind:disabled="edit"/>
        <template x-if="errors.ra">
            <p class="text-red-600 text-sm" x-text="errors.ra[0]"></p>
        </template>
    </div>
    {{-- Nome do aluno --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Aluno"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full"
                 placeholder="Nome do aluno" x-model="name"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>
    {{-- Email do aluno --}}
    <div class="mt-4">
        <x-label for="email" value="Email do Aluno"/>
        <x-input id="email" type="text" autocomplete="email" class="w-full"
                 placeholder="E-mail do aluno" x-model="email"/>
        <template x-if="errors.email">
            <p class="text-red-600 text-sm" x-text="errors.email[0]"></p>
        </template>
    </div>
    {{-- Semestre do aluno --}}
    <div class="mt-4">
        <x-label for="semester" value="Semestre"/>
        <select id="semester" class="w-full rounded border-gray-300" x-model="semester">
            <option value="" disabled selected>Selecione o semestre</option>
            <template x-for="i in 10" :key="i">
                <option :value="i" x-text="i"></option>
            </template>
        </select>
        <template x-if="errors.semester">
            <p class="text-red-600 text-sm" x-text="errors.semester[0]"></p>
        </template>
    </div>
    {{-- Grupo --}}
    <div class="mt-4">
        <x-label for="group_id" value="Grupo (opcional)"/>
        <select id="group_id" class="w-full rounded border-gray-300" x-model="group_id">
            <option value="" selected>Selecione um grupo</option>
            <template x-for="group in groups" :key="group.id">
                <option :value="group.id" x-text="group.theme ?? '-'"></option>
            </template>
        </select>
        <template x-if="errors.group_id">
            <p class="text-red-600 text-sm" x-text="errors.group_id[0]"></p>
        </template>
    </div>
    {{-- Curso --}}
    <div class="mt-4">
        <x-label for="course_id" value="Curso (opcional)"/>
        <select id="course_id" class="w-full rounded border-gray-300" x-model="course_id">
            <option value="" selected>Selecione um curso</option>
            <template x-for="course in courses" :key="course.id">
                <option :value="course.id" x-text="course.name ?? '-'"></option>
            </template>
        </select>
        <template x-if="errors.course_id">
            <p class="text-red-600 text-sm" x-text="errors.course_id[0]"></p>
        </template>
    </div>
</div>
