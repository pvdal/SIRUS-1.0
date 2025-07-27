@props(['coordinators' => 'coordinators'])

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
        <option value="" disabled selected>Selecione o coordenador</option>
        @foreach($coordinators as $coordinator)
            <option value="{{ $coordinator->id}}">{{ $coordinator->user->name ?? '-' }}</option>
        @endforeach
    </select>
    {{--<x-input id="coordinator_id" type="text" class="w-full"
                 placeholder="CPF do coordenador" x-model="coordinator_id"/>--}}
    <template x-if="errors.coordinator_id">
        <p class="text-red-600 text-sm" x-text="errors.coordinator_id[0]"></p>
    </template>
</div>
