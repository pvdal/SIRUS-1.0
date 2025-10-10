<div>
    <div x-show="{{ $list }}.length > 0" class="mt-4">
        <h4 class="font-medium text-gray-700 dark:text-gray-200">{{ $title }}</h4>
        <ul class="space-y-1 mt-1">
            <template x-for="item in {{ $list }}" :key="item.{{ $key }}">
                <li class="flex items-center justify-between bg-gray-100 dark:bg-gray-700 p-2 px-4 rounded">
                    {{ $slot  }}
                </li>
            </template>
        </ul>
    </div>
</div>
