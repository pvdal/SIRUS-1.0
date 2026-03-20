<div>
    <div class=" rounded-table-wrapper">
        <div class="overlay"></div>
        <table class="min-w-full border-collapse divide-y divide-gray-300 dark:divide-gray-800 transition duration-150 ease-in-out">
            <thead class="bg-gray-100 dark:bg-gray-900/50 transition duration-150 ease-in-out">
                <tr>
                    {{ $columns }}

                    @if($haveActions)
                        <x-table.th>Ações</x-table.th>
                    @endif
                </tr>
            </thead>
            @if(!($multiLines ?? false))
                <tbody class="bg-white dark:bg-gray-800 transition duration-150 ease-in-out divide-y divide-gray-200 dark:divide-gray-700">
                    <template x-for="item in [...{{ $newItems }}, ...{{ $items }}]" :key="item.{{ $itemKey }}">
                        <tr :class="
                            {
                                'hover:bg-gray-100/40 dark:hover:bg-gray-900/20': true,
                                'bg-green-200 hover:bg-green-300/70 dark:bg-green-900 dark:hover:bg-green-800': item.origin === 'new',
                            }"
                            class="transition duration-150 ease-in-out"
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                        >
                            {{ $rows }}

                            @if($haveActions && ($actions ?? null))
                                <x-table.td>
                                    {{ $actions }}
                                </x-table.td>
                            @endif
                        </tr>
                    </template>
                </tbody>
            @endif
            @if($multiLines ?? false)
                <template x-for="item in [...{{ $newItems }}, ...{{ $items }}]" :key="item.{{ $itemKey }}">
                    <tbody class="bg-white dark:bg-gray-800 transition duration-150 ease-in-out divide-y divide-gray-200 dark:divide-gray-700 ">
                        <tr :class="
                            {
                                'hover:bg-gray-100/40 dark:hover:bg-gray-900/20': true,
                                'bg-green-200 hover:bg-green-300/70 dark:bg-green-900 dark:hover:bg-green-800': item.origin === 'new',
                            }"
                            class="transition duration-150 ease-in-out border-t border-gray-200 dark:border-gray-700 "
                            x-transition:enter="transition ease-out duration-500"
                            x-transition:enter-start="opacity-0 transform scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 transform scale-100 translate-y-0"
                        >
                            {{ $rows }}

                            @if($haveActions && ($actions ?? null))
                                <x-table.td>
                                    {{ $actions }}
                                </x-table.td>
                            @endif
                        </tr>
                        @if($addRows ?? false)
                            {{ $addRows }}
                        @endif
                    </tbody>
                </template>
            @endif
        </table>
    </div>
</div>
