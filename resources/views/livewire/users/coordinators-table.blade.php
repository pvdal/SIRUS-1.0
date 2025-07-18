<div>
    <div class="flex flex-wrap pt-4 ps-2 pe-2 sm:ps-8 sm:me-8 ">
        <x-button type="button" wire:click="open" class="min-h-10 xs:me-2 mb-2">
            Cadastrar coordenador
        </x-button>

        <x-input  type="search"  class="w-full xs:w-6/12 xs:me-2 mb-2" placeholder="Buscar..." />

        <select
            wire:model.live="statusFilter"
            class=" bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue transition-colors min-w-[168px] cursor-pointer"
        >
            <option value="active">Apenas ativos</option>
            <option value="inactive">Apenas inativos</option>
            <option value="all">Todos</option>
        </select>

        <select
            wire:model.live="registerPeriod"
            class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2.5 pr-10 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue transition-colors min-w-[160px] cursor-pointer"
        >
            <option value="">Todas as datas</option>
            <option value="today">Cadastrados hoje</option>
            <option value="week">Últimos 7 dias</option>
            <option value="month">Últimos 30 dias</option>
        </select>

        <x-secondary-button>
            l
        </x-secondary-button>
    </div>
    <x-dialog-modal wire:model="showCreateModal">
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
            <button wire:click="closeCreateModal" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                Fechar
            </button>
        </x-slot>
    </x-dialog-modal>

    <table class="min-w-full border border-gray-300 divide-y divide-gray-200 mt-5">
        <thead class="bg-gray-100">
        <tr>
            <th class="px-4 py-2 text-center text-gray-700 hidden sm:table-cell">CPF</th>
            <th class="px-4 py-2 text-center text-gray-700">Nome</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden md:table-cell">Email</th>
            <th class="px-4 py-2 text-center text-gray-700 hidden lg:table-cell">Estado</th>
            <th class="px-4 py-2 text-center text-gray-700">Ações</th>
        </tr>
        </thead>
        <tbody class="bg-white">
        @foreach ($users as $user)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 border text-center border-gray-300 hidden sm:table-cell">{{ $user['cpf'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300">{{ $user['name'] }}</td>
                <td class="px-4 py-2 border text-center border-gray-300 hidden md:table-cell">{{ $user['email'] }}</td>
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
