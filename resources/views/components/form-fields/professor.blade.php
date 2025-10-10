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

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
