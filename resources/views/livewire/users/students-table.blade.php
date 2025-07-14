<div>
    <div class="flex-col space-y-2 xs:space-y-0 xs:space-x-2 xs:flex-row pt-4 ps-2 pe-2 sm:ps-8 sm:me-8">
        <x-button type="button" wire:click="open" class="bg-primary-blue hover:bg-primary-blue hover:opacity-90 min-h-10">
            Cadastrar aluno
        </x-button>
        <x-input type="search" class="w-full xs:w-6/12 xs:ms-4" placeholder="Buscar..." />
    </div>
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Cadastre um aluno
        </x-slot>

        <x-slot name="content">
            @if (session()->has('success'))
                <div class="bg-green-200 text-green-800 p-2 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <x-banner/>

            <div>
                <x-label for="ra" value="RA"/>
                <x-input id="ra" class="w-full" type="number" wire:model.lazy="ra" wire:keydown="resetError('ra')" wire:blur="validateRa"/>
            </div>
            @error('ra')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror

            <div class="mt-4">
                <x-label for="name" value="Nome"/>
                <x-input id="name" class="w-full" type="text" wire:model="name"/>
            </div>
            @error('name')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror

            <div class="mt-4">
                <x-label for="email" value="E-mail"/>
                <x-input id="email" class="w-full" type="email" wire:model.lazy="email" wire:keydown="resetError('email')" wire:blur="validateEmail"/>
            </div>
            @error('email')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror

            <div class="mt-4">
                <x-label value="Semestre"/>
                <select wire:model="semester" class="w-full rounded border-gray-300">
                    <option value="" disabled selected>Selecione o semestre</option>
                    @for($i=1;$i<=10;$i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            @error('semester')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror

            <div class="mt-4">
                <x-label for="group_id" value="Grupo"/>
                <x-input id="group_id" class="block mt-1 w-full" type="text" wire:model="group_id"/>
            </div>
            <x-input-error :for="'group_id'"/>

            <div class="mt-4">
                <x-label for="course_id" value="Curso"/>
                <x-input id="course_id" class="w-full" type="text" wire:model="course_id"/>
            </div>
            @error('course_id')
            <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </x-slot>

        <x-slot name="footer">
            <button type="button" wire:click="save" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Salvar
            </button>
            <button type="button" wire:click="close" class="px-4 py-2 ml-3 bg-red-500 text-white rounded hover:bg-red-600">
                Fechar
            </button>
        </x-slot>
    </x-dialog-modal>

    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-5">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-center text-gray-700 hidden xs:table-cell">RA</th>
            <th class="px-4 py-2 text-center text-gray-700">Nome</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Email</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Semestre</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">Grupo</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Curso</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Estado</th>
            <th class="px-4 py-2 text-center text-gray-700">Ações</th>
        </tr>
        </thead>
        <tbody class="bg-white">
        @foreach ($students as $student)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center border-gray-300 hidden xs:table-cell">{{ $student->ra }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">{{ $student->user->name }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $student->user->email }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $student->semester }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $student->group_id }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $student->course_id }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $student->user->state == 1 ? 'Ativo' : 'Inativo' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button class="min-w-[98px]">
                        Alterar
                    </x-button>
                    <x-danger-button>
                        Inativar
                    </x-danger-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="p-2 flex justify-center mt-2 mb-4">
        {{ $students->links() }}
    </div>
</div>

