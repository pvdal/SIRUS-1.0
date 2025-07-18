<x-app-layout>
    <x-slot name="title">
        Grupos
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Grupos cadastrados') }}
        </h2>
    </x-slot>

    <x-main-content>
        <div class="bg-white border-b border-gray-300">
            <div class="max-w-[1900px] mx-auto">
                <div class="flex justify-between h-16 w-full  p-3">
                    <div class="flex gap-2">
                        <x-button type="button" class="bg-primary-blue hover:bg-primary-blue hover:opacity-90">
                            Novo grupo
                        </x-button>
                    </div>
                </div>
            </div>
        </div>
        @livewire('groups-table')
    </x-main-content>
</x-app-layout>
