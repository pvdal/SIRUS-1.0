<div {{ $attributes->merge(['class' => 'flex flex-wrap pt-4 ps-2 pe-2 sm:ps-8 sm:me-8']) }}>
    {{-- Botão principal (ex: Cadastrar) --}}
    @isset($primaryAction)
        <x-button
            id="create"
            type="button"
            wire:click="{{ $getPrimaryActionClick() }}"
            class="min-h-10 me-2 mb-2 {{ $primaryAction['class'] ?? '' }}"
        >
            {{ $primaryAction['label'] ?? 'Ação' }}
        </x-button>
    @endisset

    {{-- Campo de busca --}}
    @isset($searchModel)
        <x-input
            type="search"
            wire:model.debounce.500ms="{{ $searchModel }}"
            class="w-full xs:w-4/12 me-2 mb-2"
            placeholder="{{ $searchPlaceholder ?? 'Buscar...' }}"
        />
    @endisset

    @isset($statusFilter)
        <select
            wire:model="{{ $statusFilter}}"
            class="appearance-none border border-gray-300 rounded-lg px-4 py-2.5 pr-10 me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue min-w-[168px] cursor-pointer"
        >
            <option value="1">Apenas ativos</option>
            <option value="0">Apenas inativos</option>
            <option value="">Todos</option>
        </select>
    @endisset

    @isset($registerPeriod)
        <select
            wire:model="{{ $registerPeriod}}"
            class="appearance-none border border-gray-300 rounded-lg px-4 py-2.5 pr-10 me-2 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue min-w-[160px] cursor-pointer"
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
            type="button"
            wire:click="{{ $getClearActionClick() }}"
            class="appearance-none border border-gray-300 rounded-lg px-6 py-2.5 mb-2 text-sm text-gray-700 focus:ring-2 focus:ring-secondary-blue focus:border-secondary-blue min-w-[168px] cursor-pointer inline-flex items-center justify-between gap-2"
        >
            {{ $clearAction['label'] ?? 'Limpar filtros' }}
            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m-7 0a1 1 0 011-1h4a1 1 0 011 1m-7 0h8" />
            </svg>
        </button>
    @endisset

    {{-- Ações adicionais via slot --}}
    {{ $slot }}
</div>
