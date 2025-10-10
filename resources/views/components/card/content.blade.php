@props([
    'header' => null,
    'title' => null,
    'members' => null,
    'membersCount' => null,
    'paperAction' => null,
    'actions' => null,
    'state' => null
])
<div {{ $attributes->merge(['class' => 'flex flex-col flex-1 overflow-hidden h-full']) }}>
    {{-- Header --}}
    @if($header)
        <div>
            <div class="flex-shrink-0 h-[35px] w-full flex items-center gap-3 px-6 py-1">
                {{ $header }}
            </div>
            <hr class="mt-0 block border-gray-300 dark:border-gray-700 transition duration-150 ease-in-out">
        </div>
    @endif

    {{-- Corpo do card --}}
    <div class="flex flex-col flex-1 overflow-hidden h-full pb-1">

        {{-- Título --}}
        @if($title)
            <div class="flex-shrink-0 flex justify-start items-center text-gray-800 dark:text-gray-200 py-4 px-6 max-w-full h-[85px] transition duration-150 ease-in-out">
                {{ $title }}
            </div>
            <hr class="border-t mb-2 mx-4 border-gray-300 dark:border-gray-700 transition duration-150 ease-in-out"/>
        @endif

        {{-- Lista de membros --}}
        @if($members)
            @if($membersCount)
                <div class="flex items-center gap-1 text-sm text-gray-700 dark:text-gray-300 font-medium px-6 pb-2 flex-shrink-0 transition duration-150 ease-in-out">
                    <x-lucide-users class="w-4 h-4 text-gray-500 dark:text-gray-400 transition duration-150 ease-in-out" />
                    <span
                        x-text="`${item.{{ $membersCount }}.length} ${item.{{ $membersCount }}.length === 1 ? 'Membro' : 'Membros'}`">
                    </span>
                </div>
            @endif

            {{-- Scroll interno da lista --}}
            <div class="flex-1  dark:bg-gray-600/30  overflow-y-auto scrollbar-custom border border-gray-200 dark:border-gray-700 px-6 mx-5 rounded-md max-h-[120px] transition duration-150 ease-in-out">
                <ul class="space-y-1 text-gray-600 dark:text-gray-300 text-sm py-1 transition duration-150 ease-in-out">
                    {{ $members }}
                </ul>
            </div>
        @endif

        {{-- Slot livre (ex: detalhes extras) --}}
        {{ $slot }}

        {{-- Paper action --}}
        @if($paperAction)
            <div class="mt-auto">
                <div class="flex-shrink-0 min-w-full px-5 py-1">
                    {{ $paperAction }}
                </div>
            </div>
        @endif
        <hr class="border-t mt-auto border-gray-300 dark:border-gray-700 mx-4 transition duration-150 ease-in-out"/>
        {{-- Ações --}}
        @if($actions || $state)
            <div class="flex flex-wrap gap-3 items-center justify-between px-5 py-2 flex-shrink-0 min-h-[50px]">
                @if($state)
                    {{ $state }}
                @endif

                @if($actions)
                    <div class="flex flex-wrap gap-2 ms-4">
                        {{ $actions }}
                    </div>
                @endif
            </div>
        @endif
    </div>
</div>
