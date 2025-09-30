<x-app-layout>
    <x-slot name="title">
        Calendário
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agenda de avaliação') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/evaluation/eventsData.js--}}
        <div x-data="eventsData()">
            <x-evaluation.events-content/>
        </div>
    </x-main-content>
</x-app-layout>
