<div>
    {{-- Nome do coordenador --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Coordenador"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full mt-1"
                 placeholder="Nome do coordenador" x-model="name"
                 @keydown.enter="saveCoordinator"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>
    {{-- Email do coordenador --}}
    <div class="mt-4">
        <x-label for="email" value="Email do Coordenador"/>
        <x-input id="email" type="text" autocomplete="email" class="w-full mt-1"
                 placeholder="E-mail do coordenador" x-model="email"
                 @keydown.enter="saveCoordinator"/>
        <template x-if="errors.email">
            <x-form-fields.field-error x-text="errors.email[0]"/>
        </template>
    </div>
    {{-- Formação do coordenador --}}
    <div class="mt-4">
        <x-label for="education" value="Formação do Coordenador"/>
        <x-input id="education" type="text" autocomplete="name" class="w-full mt-1"
                 placeholder="Formação do coordenador" x-model="education"
                 @keydown.enter="saveCoordinator"/>
        <template x-if="errors.education">
            <x-form-fields.field-error x-text="errors.education[0]"/>
        </template>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
