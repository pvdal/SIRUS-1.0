@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-6']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title ?? '' }}</x-slot>
        <x-slot name="description">{{ $description ?? '' }}</x-slot>
    </x-section-title>

    <div class="mt-5 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="px-4 py-5 bg-white dark:bg-gray-900 border border-b-0 border-gray-200 dark:border-gray-950 sm:p-6 shadow transition duration-150 ease-in-out {{ isset($actions) ? 'sm:rounded-tl-md sm:rounded-tr-md' : 'sm:rounded-md' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-4 py-3 bg-gray-50 dark:bg-gray-800 text-end sm:px-6 border border-t-0 border-gray-200 dark:border-gray-950 shadow sm:rounded-bl-md sm:rounded-br-md transition duration-150 ease-in-out">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
