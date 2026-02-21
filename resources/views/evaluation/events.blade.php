<x-app-layout>
    <x-slot name="title">
        Calendário
    </x-slot>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-dark leading-tight">
            {{ __('Bancas agendadas') }}
        </h2>
    </x-slot>

    {{-- Conteúdo principal --}}
    <x-main-content>
        {{-- Chamada da função alpine -> recources/js/components/evaluation/eventsData.js--}}
        <div x-data="eventsData()"
             x-init='init(@json($events),@json($courses))'>
            {{-- Componente com o conteúdo que o alpine vai manipular --}}
            <template x-if="events">
                <x-evaluation.events-content/>
            </template>
            {{-- Div exibida enquanto os dados não chegam no front --}}
            <x-feedback.loading/>
        </div>
    </x-main-content>
    {{-- Trecho importante, força refresh do script, garante bom comportamento do dynamicToken --}}
    @forceFresh
</x-app-layout>
