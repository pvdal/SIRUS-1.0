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
        <div class="max-w-[1900px] mx-auto px-4 py-6">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($items as $item)
                    <div class="border border-gray-300 rounded-lg shadow h-72 p-4 bg-white">
                        <!-- Conteúdo do card -->
                        <h2 class="text-lg font-semibold">{{ $item['titulo']}}</h2>
                        <p class="mt-2 text-gray-600">{{ $item['descricao'] }}</p>
                        <!-- ... -->
                    </div>
                @endforeach
            </div>
        </div>

    </x-main-content>
</x-app-layout>
