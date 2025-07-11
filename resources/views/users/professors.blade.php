<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Professores cadastrados') }}
        </h2>
    </x-slot>

    <x-main-content>
        <x-nav-users-table>
            @livewire('users.professors-table')
        </x-nav-users-table>
    </x-main-content>

</x-app-layout>
