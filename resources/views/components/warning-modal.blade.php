@props(['model','id' => null, 'maxWidth' => '2xl', 'icon' => null, 'title' => null, 'content' => null, 'warningType' => 'Confirmação'])

@php
    $maxWidth = [
    'sm' => 'xs:max-w-sm',
    'md' => 'xs:max-w-md',
    'lg' => 'xs:max-w-lg',
    'xl' => 'xs:max-w-xl',
    '2xl' => 'xs:max-w-2xl',
    ][$maxWidth ?? '2xl'];
@endphp

<div
    x-on:close.stop="{{ $attributes->get('x-model') }} = false"
    x-on:keydown.escape.window="{{ $attributes->get('x-model') }} = false"
    x-show="{{ $attributes->get('x-model') }}"
    id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 xs:px-0 z-50"
    style="display: none;"
>
    <div x-show="{{ $attributes->get('x-model') }}" class="fixed inset-0 transform transition-all"
         x-on:click="{{ $attributes->get('x-model') }} = false"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-700 opacity-75"></div>
    </div>


    <div x-show="{{ $attributes->get('x-model') }}" class="mb-6 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all {{ $maxWidth }} xs:mx-auto"
         x-trap.inert.noscroll="{{ $attributes->get('x-model') }}"
         x-transition:enter-start="opacity-0 translate-y-4 xs:translate-y-0 xs:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 xs:scale-100"
         x-transition:leave-start="opacity-100 translate-y-0 xs:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 xs:translate-y-0 xs:scale-95"
    >
        <div>
            <div class="px-8 py-5 xs:px-5">
                <div class="mt-3 text-start xs:mt-0 xs:mx-4 ">
                    @if($title)
                        <h3 class="text-lg font-medium text-gray-900">
                            @if($warningType)
                                <template x-if="{{ $warningType }} === 'Confirmação'">
                                    <div class="flex items-center gap-2 text-secondary-orange dark:text-orange-400">
                                        <div class="bg-secondary-orange rounded-[20px] p-2">
                                            <x-lucide-alert-triangle class="text-white  w-5 h-5" />
                                        </div>
                                        {{ $title }}
                                    </div>
                                </template>
                                <template x-if="{{ $warningType }} === 'Erro'">
                                    <div class="flex items-center gap-2 text-red-700">
                                        <div class="bg-red-700 rounded-[20px] p-2">
                                            <x-lucide-x-circle class="text-white w-5 h-5" />
                                        </div>
                                        {{ $title }}
                                    </div>
                                </template>
                            @endif
                        </h3>
                    @endif
                    @if($content)
                        <div class="mt-4 text-sm text-gray-600 dark:text-gray-200">
                            {{ $content }}
                        </div>
                    @endif
                </div>
            </div>

            <div class="flex flex-wrap justify-end gap-3 px-6 py-4 bg-gray-100 dark:bg-gray-700/70 text-end">
                {{ $footer }}
            </div>
        </div>
    </div>
</div>
