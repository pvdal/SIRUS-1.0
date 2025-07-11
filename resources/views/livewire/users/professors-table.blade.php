<div>
    <div class="pt-4 ps-8">
        <button wire:click="open" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Abrir Modal
        </button>
    </div>
    <x-dialog-modal wire:model="showModal">
        <x-slot name="title">
            Exemplo de Modal
        </x-slot>

        <x-slot name="content">
            <form action="#">
                <x-label value="Nome"/>
                <x-input class="w-full"/>
                <x-label value="Nome"/>
                <x-input class="w-full"/>
                <x-label value="Nome"/>
                <x-input class="w-full"/>
            </form>
        </x-slot>

        <x-slot name="footer">
            <button wire:click="close" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
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
        @foreach ($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center border-gray-300 hidden xs:table-cell">{{ $user['ra'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">{{ $user['name'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $user['email'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $user['semestre'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $user['grupo'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $user['curso'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden lg:table-cell">{{ $user['estado'] == 1 ? 'Ativo' : 'Inativo' }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">
                    <x-button class="min-w-[98px] !bg-blue-700">
                        Alterar
                    </x-button>
                    <x-button class="bg-red-800">
                        Inativar
                    </x-button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
