<div>
    {{-- RA do aluno --}}
    <div class="mt-4">
        <x-label for="ra" value="RA do Aluno"/>
        <x-input id="ra"
                 type="text"
                 autocomplete="ra"
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
    <div class="mt-4">
        <x-label for="group_id" value="Grupo (opcional)"/>
        <x-select id="group_id" x-model="group_id" class="w-full mt-1">
            <option value="" selected>Selecione um grupo</option>
            <template x-for="group in groups" :key="group.id">
                <option :value="group.id" x-text="group.theme ?? '-'"></option>
            </template>
        </x-select>
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
