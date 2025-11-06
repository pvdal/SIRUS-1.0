<button
    type="button"
    class="flex items-center border border-gray-200 dark:border-gray-700 justify-start gap-2 px-3 py-2 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600/30 dark:hover:border-gray-700 transition duration-150 ease-in-out cursor-pointer w-full max-w-full"
    {{ $attributes }}
>
    {{ $slot }}
    <x-lucide-link class="w-4 h-4 text-gray-600 dark:text-gray-200 flex-shrink-0 ms-auto transition duration-150 ease-in-out"/>
</button>
