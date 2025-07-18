<x-app-layout>
    <x-slot name="title">
        Calendário
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agenda de avaliação') }}
        </h2>
    </x-slot>

    <x-main-content>
        <div class="p-0 border-4 rounded overflow-hidden border-strong-blue">
            <div class="bg-primary-blue bg-blend-darken">
                <h1 class="text-center text-white border-b border-gray-600 pb-5 p-4 text-base sm:text-lg md:text-2xl lg:text-3xl">
                    AGENDA DE AVALIAÇÃO DO SIMBAJU
                </h1>
            </div>
            <div class="flex justify-center">
                <div id="calendar" class="p-4 w-full max-w-4xl">
                    <!-- conteúdo do calendário -->
                </div>
            </div>
        </div>
    </x-main-content>
</x-app-layout>
