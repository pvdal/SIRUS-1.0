<div>
    {{-- Nome do Curso --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Curso"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full mt-1"
                 placeholder="Nome do curso" x-model="name"
                 @keydown.enter="saveCourse"/>
        <template x-if="errors.name">
            <x-form-fields.field-error x-text="errors.name[0]"/>
        </template>
    </div>

    {{-- Turno (shift) --}}
    <div class="mt-4">
        <x-label for="shift" value="Turno"/>
        <x-select id="shift" class="w-full mt-1" x-model="shift">
            <option value="" disabled selected>Selecione o turno</option>
            <option value="morning">Matutino</option>
            <option value="afternoon">Vespertino</option>
            <option value="night">Noturno</option>
        </x-select>
        <template x-if="errors.shift">
            <x-form-fields.field-error x-text="errors.shift[0]"/>
        </template>
    </div>

    {{-- ID do Coordenador --}}
    <div class="mt-4">
        <x-label for="coordinator_id" value="Coordenador (opcional)"/>
        <x-select id="coordinator_id" class="w-full mt-1" x-model="coordinator_id">
            <option value="" selected>Selecione o coordenador</option>
            <template x-for="coordinator in coordinators" :key="coordinator.id">
                <option :value="coordinator.id" x-text="coordinator.name ?? '-'"></option>
            </template>
        </x-select>
        <template x-if="errors.coordinator_id">
            <x-form-fields.field-error x-text="errors.coordinator_id[0]"/>
        </template>
    </div>

    {{-- Timestamps --}}
    <template x-if="edit && (created_at || updated_at)">
        <x-form-fields.timestamps/>
    </template>
</div>
