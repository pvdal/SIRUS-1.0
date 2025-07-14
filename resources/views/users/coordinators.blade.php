<x-app-layout>
    <x-slot name="title">
        Usuários
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Coordenadores cadastrados') }}
        </h2>
    </x-slot>

    <x-main-content>
        <x-nav-users-table>
            @livewire('users.coordinators-table')
        </x-nav-users-table>
    </x-main-content>
</x-app-layout>
