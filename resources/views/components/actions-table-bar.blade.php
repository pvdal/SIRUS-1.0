@props(['minWidth', 'searchWidth' => null,])

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

<div {{ $attributes->merge(['class' => 'flex flex-wrap justify-center pt-4 ps-2 pe-2 sm:ps-4 sm:me-4']) }}>
    {{-- Botão principal (ex: Cadastrar) --}}
    @isset($primaryAction)
        <x-button
            id="create"
            type="button"
            x-on:click="{!! $primaryButton !!} {{ $primaryAdd ?? '' }}"
            class="min-h-10 me-1 xs:me-2 mb-2 {{ $minWidth }}{{ $primaryAction['class'] ?? '' }}"
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
            class="{{ $minWidth }} max-w-[170px] me-1 xs:max-w-full {{ $searchWidth ?? 'sm:w-4/12' }} xs:me-2 mb-2"
            placeholder="{{ $searchPlaceholder ?? 'Buscar...' }}"
        />
    @endisset

    {{-- Filtros extras (slots) --}}
    {{ $filters ?? '' }}

    {{-- Filtro de status --}}
    @isset($statusFilter)
        <div id="statusFilter" class="relative block {{ $minWidth }} max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2">
            <button @click="statusFilter.drop = !statusFilter.drop"
                    class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                           text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue
                           focus:border-secondary-blue cursor-pointer"
                    x-bind:disabled="loading"
                    :title="statusFilter.name || 'Selecione em estado'">
                <span class="truncate" x-text="statusFilter.name || 'Selecione em estado'"></span>
                <x-lucide-chevron-down class="w-4 h-4 text-gray-700 flex-shrink-0 ms-auto" />
            </button>

            <ul x-show="statusFilter.drop"
                @click.outside="statusFilter.drop = false"
                class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom">
                <li @click="statusFilter.value = ''; statusFilter.name = 'Todos os estados'; statusFilter.drop = false; {{ $loadFunction }}"
                    class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer">
                    Todos os estados
                </li>

                <li @click="statusFilter.value = 1; statusFilter.name = 'Apenas ativos'; statusFilter.drop = false; {{ $loadFunction }}"
                    class="px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer"
                    x-text="'Apenas ativos'">
                </li>
                <li @click="statusFilter.value = 0; statusFilter.name = 'Apenas inativos'; statusFilter.drop = false; {{ $loadFunction }}"
                    class="px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer"
                    x-text="'Apenas inativos'">
                </li>
            </ul>
        </div>
    @endisset
    {{-- Filtro de período de cadastro --}}
    @isset($registerPeriod)
        <div id="registerPeriod" class="relative block {{ $minWidth }} max-w-[170px] md:max-w-[200px] w-full me-1 xs:me-2">
            <button @click="registerPeriod.drop = !registerPeriod.drop"
                    class="flex justify-between items-center pr-4 min-w-[170px] max-w-[200px] w-full whitespace-nowrap overflow-hidden text-ellipsis border border-gray-300 rounded-lg
                           text-left px-4 py-2.5 xs:me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue
                           focus:border-secondary-blue cursor-pointer"
                    x-bind:disabled="loading"
                    :title="registerPeriod.name || 'Selecione um periodo'">
                <span class="truncate" x-text="registerPeriod.name || 'Selecione um periodo'"></span>
                <x-lucide-chevron-down class="w-4 h-4 text-gray-700 flex-shrink-0 ms-auto" />
            </button>

            <ul x-show="registerPeriod.drop"
                @click.outside="registerPeriod.drop = false"
                class="absolute min-w-[170px] md:max-w-[200px] w-full border bg-white mt-1 rounded-lg max-h-60 overflow-auto z-50 scrollbar-custom">
                <li @click="registerPeriod.value = ''; registerPeriod.name = 'Todas as datas'; registerPeriod.drop = false; {{ $loadFunction }}"
                    class="px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer">
                    Todas as datas
                </li>

                <li @click="registerPeriod.value = 'today'; registerPeriod.name = 'Cadastrados hoje'; registerPeriod.drop = false; {{ $loadFunction }}"
                    class="px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer"
                    x-text="'Cadastrados hoje'">
                </li>
                <li @click="registerPeriod.value = 'week'; registerPeriod.name = 'Últimos 7 dias'; registerPeriod.drop = false; {{ $loadFunction }}"
                    class="px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer"
                    x-text="'Últimos 7 dias'">
                </li>
                <li @click="registerPeriod.value = 'month'; registerPeriod.name = 'Últimos 30 dias'; registerPeriod.drop = false; {{ $loadFunction }}"
                    class="px-4 py-1 text-sm text-gray-700 hover:bg-gray-100 break-words cursor-pointer"
                    x-text="'Últimos 30 dias'">
                </li>
            </ul>
        </div>
    @endisset

    {{-- Botão limpar --}}
    @isset($clearAction)
        <button
            id="clearAction"
            type="button"
            x-on:click="
                {!! $clearButton !!}
                {{ $loadFunction }}
            "
            class="appearance-none border border-gray-300 rounded-lg me-1 {{ $minWidth }} px-6 py-2.5 mb-2 xs:me-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue cursor-pointer inline-flex items-center justify-between gap-2"
            :title="'Limpar filtros'"
        >
            {{ $clearAction['label'] ?? 'Limpar filtros' }}
            <x-lucide-trash-2 class="w-4 h-4 text-gray-500"/>
        </button>
    @endisset

    {{-- Ações adicionais via slot --}}
    {{ $slot }}
</div>
