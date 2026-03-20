<div>
    {{-- Nome do professor --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Professor"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full mt-1"
                 placeholder="Nome do professor" x-model="name"
                 @keydown.enter="saveCoordinator"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>

    {{-- Email do professor --}}
    <div class="mt-4">
        <x-label for="email" value="Email do Professor"/>
        <x-input id="email" type="text" autocomplete="email" class="w-full mt-1"
                 placeholder="E-mail do professor" x-model="email"
                 @keydown.enter="saveProfessor"/>
        <template x-if="errors.email">
            <x-form-fields.field-error x-text="errors.email[0]"/>
        </template>
    </div>

    {{-- Formação do professor --}}
    <div class="mt-4">
        <div class="flex items-center space-x-2">
            <x-checkbox x-model="education.graduation.checked"/>
            <x-label for="education-graduation" value="Graduação"/>
        </div>

        <div x-show="education.graduation.checked">
            <x-input id="education-graduation" type="text" autocomplete="name" class="w-full mt-1"
                     placeholder="Principal graduação do professor" x-model="education.graduation.course"
                     @keydown.enter="saveCoordinator"/>
            <template x-if="errors['education.0.course']">
                <x-form-fields.field-error x-text="errors['education.0.course'][0]" />
            </template>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex items-center space-x-2">
            <x-checkbox x-model="education.specialization.checked"/>
            <x-label for="education-specialization" value="Especialização"/>
        </div>

        <div x-show="education.specialization.checked">
            <x-input id="education-specialization" type="text" autocomplete="name" class="w-full mt-1"
                     placeholder="Principal especialização do professor" x-model="education.specialization.course"
                     @keydown.enter="saveCoordinator"/>
            <template x-if="errors['education.1.course']">
                <x-form-fields.field-error x-text="errors['education.1.course'][0]" />
            </template>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex items-center space-x-2">
            <x-checkbox x-model="education.masters.checked"/>
            <x-label for="education-masters" value="Mestrado"/>
        </div>

        <div x-show="education.masters.checked">
            <x-input id="education-masters" type="text" autocomplete="name" class="w-full mt-1"
                     placeholder="Principal mestrado do professor" x-model="education.masters.course"
                     @keydown.enter="saveCoordinator"/>
            <template x-if="errors['education.2.course']">
                <x-form-fields.field-error x-text="errors['education.2.course'][0]" />
            </template>
        </div>
    </div>
    <div class="mt-4">
        <div class="flex items-center space-x-2">
            <x-checkbox x-model="education.doctorate.checked"/>
            <x-label for="education-doctorate" value="Doutorado"/>
        </div>

        <div x-show="education.doctorate.checked">
            <x-input id="education-doctorate" type="text" autocomplete="name" class="w-full mt-1"
                     placeholder="Principal doutorado do professor" x-model="education.doctorate.course"
                     @keydown.enter="saveCoordinator"/>
            <template x-if="errors['education.3.course']">
                <x-form-fields.field-error x-text="errors['education.3.course'][0]" />
            </template>
        </div>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
