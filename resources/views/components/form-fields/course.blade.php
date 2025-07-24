@props(['typeModal' => ''])
<div>
    @isset($typeModal)
        {{-- ID (geralmente readonly no update, ou escondido no create) --}}
        @if($typeModal === 'update')
            <div class="mt-4">
                <x-label for="id" value="ID" />
                <x-input id="id" type="text" class="w-full bg-gray-100 cursor-not-allowed" wire:model.lazy="id" readonly />
            </div>
        @endif

        {{-- Nome do Curso --}}
        <div class="mt-4">
            <x-label for="name" value="Nome do Curso" />
            <x-input id="name" type="text" class="w-full" placeholder="Nome do curso" wire:model.lazy="name" wire:input="resetError('name')" />
        </div>
        <x-input-error :for="'name'"/>

        {{-- Turno (shift) --}}
        <div class="mt-4">
            <x-label for="shift" value="Turno" />
            <select id="shift" class="w-full rounded border-gray-300" wire:model.lazy="shift" wire:change="resetError('shift')">
                <option value="" disabled selected>Selecione o turno</option>
                <option value="Manhã">Manhã</option>
                <option value="Tarde">Tarde</option>
                <option value="Noite">Noite</option>
                <option value="Integral">Integral</option>
            </select>
        </div>
        <x-input-error :for="'shift'"/>

        {{-- CPF do Coordenador --}}
        <div class="mt-4">
            <x-label for="coordinator_cpf" value="CPF do Coordenador" />
            <x-input
                id="coordinator_cpf"
                type="text"
                class="w-full"
                placeholder="CPF do coordenador"
                wire:model.lazy="coordinator_cpf"
                wire:input="resetError('coordinator_cpf')"
            />
        </div>
        <x-input-error :for="'coordinator_cpf'"/>
    @endisset
</div>
