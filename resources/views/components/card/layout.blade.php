<div {{ $attributes->merge([
    'class' => '
        flex flex-col border border-gray-300 dark:border-gray-700 rounded-lg shadow
        bg-white dark:bg-gray-800 dark:hover:bg-gray-800
        w-full xs:w-[400px] md:w-auto max-w-[420px]
        transition-all duration-150 ease-in-out
        min-h-[370px] sm:min-h-[360px] sm:max-h-[360px] overflow-hidden hover:shadow-md
    '
]) }}
     x-bind:class="{ '!bg-green-50 dark:!bg-green-900/20': item.origin === 'new' }">

    {{ $slot }}
</div>
