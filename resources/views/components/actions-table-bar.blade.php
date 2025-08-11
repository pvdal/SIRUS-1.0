@props(['minWidth'])

@php
    $primaryMethod = $primaryAction['method'] ?? null;
    $primaryParam = $primaryAction['param'] ?? null;
    $clearMethod = $clearAction['method'] ?? null;
    $clearParam = $clearAction['param'] ?? null;

    $primaryButton = $primaryMethod
        ? $primaryMethod . ($primaryParam ? "('{$primaryParam}');" : "= true; ") . '$el.blur();'
        : '$el.blur();';

    $clearButton = $primaryMethod
        ? $clearMethod . ($clearParam ? "('{$clearParam}');" : "; ") . '$el.blur();'
        : '$el.blur();';

    $minWidth = [
        '170px' => 'min-w-[170px]',
        '200px' => 'min-w-[200px]',
        '230px' => 'min-w-[230px]',
        '300px' => 'min-w-[300px]',
        'full'  => 'min-w-full',
    ][$minWidth ?? '170px'];

@endphp

<div {{ $attributes->merge(['class' => 'flex flex-wrap justify-center md:justify-start pt-4 ps-2 pe-2 sm:ps-8 sm:me-8']) }}>
    {{-- Botão principal (ex: Cadastrar) --}}
    @isset($primaryAction)
        <x-button
            id="create"
            type="button"
            x-on:click="{!! $primaryButton !!} "
            class="min-h-10 xs:me-2 mb-2 {{ $minWidth }}{{ $primaryAction['class'] ?? '' }}"
        >
            {{ $primaryAction['label'] ?? 'Cadastrar' }}
        </x-button>
    @endisset
    {{-- Campo de busca --}}
    @isset($searchModel)
        <x-input
            id="search"
            type="search"
            x-model="{!! $searchModel !!}"
            @keydown.enter="{{ $loadFunction }}"
            class="{{ $minWidth }} max-w-[170px] xs:max-w-full xs:w-4/12 xs:me-2 mb-2"
            placeholder="{{ $searchPlaceholder ?? 'Buscar...' }}"
        />
    @endisset
    {{-- Filtro de status --}}
    @isset($statusFilter)
        <select
            id="statusFilter"
            x-model="{!! $statusFilter !!}"
            @change="{{ $loadFunction }}"
            class="appearance-none border border-gray-300 rounded-lg {{ $minWidth }} px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue  cursor-pointer"
        >
            <option value="">Todos</option>
            <option value="1">Apenas ativos</option>
            <option value="0">Apenas inativos</option>
        </select>
    @endisset
    {{-- Filtro de período de cadastro --}}
    @isset($registerPeriod)
        <select
            id="registerPeriod"
            x-model="{!! $registerPeriod !!}"
            @change="{{ $loadFunction }}"
            class="appearance-none border border-gray-300 rounded-lg {{ $minWidth }} px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue  cursor-pointer"
        >
            <option value="">Todas as datas</option>
            <option value="today">Cadastrados hoje</option>
            <option value="week">Últimos 7 dias</option>
            <option value="month">Últimos 30 dias</option>
        </select>
    @endisset

    {{-- Filtros extras (slots) --}}
    {{ $filters ?? '' }}

    {{-- Botão limpar --}}
    @isset($clearAction)
        <button
            id="clearAction"
            type="button"
            x-on:click="
                {!! $clearButton !!}
                {{ $loadFunction }}
            "
            class="appearance-none border border-gray-300 rounded-lg {{ $minWidth }} px-6 py-2.5 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue cursor-pointer inline-flex items-center justify-between gap-2"
        >
            {{ $clearAction['label'] ?? 'Limpar filtros' }}
            <x-lucide-trash-2 class="w-4 h-4 text-gray-500"/>
        </button>
    @endisset

    {{-- Ações adicionais via slot --}}
    {{ $slot }}
</div>
