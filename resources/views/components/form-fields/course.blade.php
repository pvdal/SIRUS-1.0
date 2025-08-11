<div>
    {{-- Nome do Curso --}}
    <div class="mt-4">
        <x-label for="name" value="Nome do Curso"/>
        <x-input id="name" type="text" autocomplete="name" class="w-full"
                 placeholder="Nome do curso" x-model="name"/>
        <template x-if="errors.name">
            <p class="text-red-600 text-sm" x-text="errors.name[0]"></p>
        </template>
    </div>

    {{-- Turno (shift) --}}
    <div class="mt-4">
        <x-label for="shift" value="Turno"/>
        <select id="shift" class="w-full rounded border-gray-300" x-model="shift">
            <option value="" disabled selected>Selecione o turno</option>
            <option value="morning">Matutino</option>
            <option value="afternoon">Vespertino</option>
            <option value="night">Noturno</option>
        </select>
        <template x-if="errors.shift">
            <p class="text-red-600 text-sm" x-text="errors.shift[0]"></p>
        </template>
    </div>

    {{-- ID do Coordenador --}}
    <div class="mt-4">
        <x-label for="coordinator_id" value="Coordenador (opcional)"/>
        <select id="coordinator_id" class="w-full rounded border-gray-300" x-model="coordinator_id">
            <option value="" selected>Selecione o coordenador</option>
            <template x-for="coordinator in coordinators" :key="coordinator.id">
                <option :value="coordinator.id" x-text="coordinator.name ?? '-'"></option>
            </template>
        </select>
        <template x-if="errors.coordinator_id">
            <p class="text-red-600 text-sm" x-text="errors.coordinator_id[0]"></p>
        </template>
    </div>

    <template x-if="edit && (created_at || updated_at)">
        <div class="mt-3">
            <p class="text-sm text-gray-800" x-text="created_at"></p>
            <p class="text-sm text-gray-800" x-text="updated_at"></p>
        </div>
    </template>
</div>
