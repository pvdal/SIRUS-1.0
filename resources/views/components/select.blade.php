@props(['id' => null])

<div {{ $attributes->only('class')->merge([
            'class' => 'relative rounded-md'
        ]) }}>
    <select
        id="{{ $id }}"
        {{ $attributes->merge([
            'class' => 'block pr-9 min-h-[42px]
                rounded-md border border-gray-300 dark:border-gray-400 bg-white
                focus:border-secondary-blue focus:ring-secondary-blue
                dark:bg-gray-800 dark:text-gray-200 shadow-sm
                transition duration-150 ease-in-out'
        ]) }}
    >
        {{ $slot }}
    </select>

    <x-lucide-chevron-down
        class="absolute right-4 top-1/2 -translate-y-1/2 w-4 h-4
               text-gray-600 dark:text-gray-200 pointer-events-none"
    />
</div>
