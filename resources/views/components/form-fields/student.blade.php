<div>
    @isset($typeModal)
        <div class="mt-4">
            <x-label for="ra" value="RA"/>
            <x-input id="ra" type="number" class="w-full" placeholder="Registro Acadêmico" wire:model.lazy="ra" {{ $attributes->merge($inputRaAttributes) }}/>
        </div>
        <x-input-error :for="'ra'"/>

        <div class="mt-4">
            <x-label for="name" value="Nome"/>
            <x-input id="name" type="text" class="w-full" autocomplete="name" placeholder="Nome" wire:model.lazy="name" wire:keydown="resetError('name')"/>
        </div>
        <x-input-error :for="'name'"/>

        <div class="mt-4">
            <x-label for="email" value="E-mail"/>
            <x-input id="email" type="email" class="w-full" autocomplete="email" placeholder="E-mail" wire:model.lazy="email" wire:keydown="resetError('email')" wire:change="validateEmail('{{ $typeModal }}')"/>
        </div>
        <x-input-error :for="'email'"/>

        <div class="mt-4">
            <x-label for="semester" value="Semestre"/>
            <select id="semester" class="w-full rounded border-gray-300" wire:model.lazy="semester" wire:change="resetError('semester')">
                <option value="" disabled selected>Selecione o semestre</option>
                @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}">{{ $i }}</option>
                @endfor
            </select>
        </div>
        <x-input-error :for="'semester'"/>

        <div class="mt-4">
            <x-label for="group_id" value="Grupo"/>
            <select id="group_id" class="w-full rounded border-gray-300"  wire:model.lazy="group_id">
                <option value="" disabled selected>Selecione um grupo</option>
                @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}">Grupo {{ $i }}</option>
                @endfor
            </select>
        </div>
        <x-input-error :for="'group_id'"/>

        <div class="mt-4">
            <x-label for="course_id" value="Curso"/>
            <select id="course_id" class="w-full rounded border-gray-300" wire:model.lazy="course_id">
                <option value="" disabled selected>Selecione um curso</option>
                @for($i=1;$i<=10;$i++)
                    <option value="{{ $i }}">Curso {{ $i }}</option>
                @endfor
            </select>
        </div>
        <x-input-error :for="'course_id'"/>
    @endisset
</div>
