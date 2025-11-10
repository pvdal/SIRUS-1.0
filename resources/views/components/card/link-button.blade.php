@props(['optionsButton' => null, 'actions' => null])

<div class="flex flex-col items-center max-w-full border border-gray-200 dark:border-gray-700 transition duration-150 ease-in-out rounded-md p-[2px]">
    <div class="inline-flex w-full relative">
        <button
            type="button"
            class="flex items-center min-w-0 w-full max-w-full justify-start rounded-md gap-2 px-3 py-2 hover:bg-gray-200 dark:hover:bg-gray-600/30 transition duration-150 ease-in-out cursor-pointer"
            {{ $attributes }}
        >
            {{ $slot }}
        </button>
        @if(isset($optionsButton))
            {{ $optionsButton }}
        @endif
    </div>
    @if(isset($actions))
        {{ $actions }}
    @endif
</div>

