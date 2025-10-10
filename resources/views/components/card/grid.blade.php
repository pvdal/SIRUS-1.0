@props(['items' => null, 'newItems' => null, 'itemKey' => 'id'])
<div>
    <div class="flex flex-col justify-center md:grid md:grid-cols-2 lg:grid-cols-3 xlg:grid-cols-4 gap-4 items-center">
        @if($newItems && $items && $itemKey)
            <template x-for="item in [...{{ $newItems }}, ...{{ $items }}]" :key="item.{{ $itemKey }}">
                {{ $slot }}
            </template>
        @endif
    </div>
</div>
