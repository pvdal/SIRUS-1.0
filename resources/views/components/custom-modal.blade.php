@props(['model','id' => null, 'maxWidth' => '2xl', 'icon' => null, 'titleClass' => '',])

@php
    $maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '3xl' => 'sm:max-w-3xl'
    ][$maxWidth ?? '2xl'];
@endphp

<div
    x-show="{{ $attributes->get('x-model') }}"
    x-on:keydown.escape.window="{{ $attributes->get('x-model') }} = false"
    x-on:close.stop="{{ $attributes->get('x-model') }} = false"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    x-init="$watch('{{ $attributes->get('x-model') }}', value => {
        document.body.classList.toggle('overflow-hidden', value)
    })"
    x-cloak
>
    <!-- Backdrop -->
    <div x-show="{{ $attributes->get('x-model') }}" class="fixed inset-0 transform transition-all"
         x-on:click="{{ $attributes->get('x-model') }} = false"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-700 opacity-75"></div>
    </div>

    <!-- Modal -->
    <div x-show="{{ $attributes->get('x-model') }}" class="mb-6 bg-white dark:bg-gray-800 dark:border dark:border-gray-900 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-trap.inert.noscroll="{{ $attributes->get('x-model') }}"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        @isset($title)
        <div class="px-6 py-4 border-b dark:border-gray-700">
            <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200 {{ $titleClass }}">
                {{ $title }}
            </h2>
        </div>
        @endisset
        @isset($content)
        <div class="px-6 py-4 mt-4 text-sm text-gray-600 dark:text-gray-300">
            {{ $content }}
        </div>
        @endisset
        @isset($footer)
            <div class="px-6 py-4 border-t dark:border-gray-700 justify-end flex flex-wrap gap-2">
                {{ $footer }}
            </div>
        @endisset

    </div>
</div>
