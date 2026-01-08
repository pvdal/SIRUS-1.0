@props(['id' => null, 'maxWidth' => null, 'icon' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-white dark:bg-gray-800 px-8 py-5 xs:px-5 mt-3 xs:mx-4 transition">
        <div class="sm:flex sm:items-center">
            @if($icon === 'Confirmação')
                <div class="mx-auto shrink-0 flex items-center justify-center size-12 rounded-full bg-secondary-orange sm:mx-0 sm:size-10">
                    <x-lucide-alert-triangle class="text-white w-6 h-6" />
                </div>
            @elseif($icon === 'Erro')
                <div class="mx-auto shrink-0 flex items-center justify-center size-12 rounded-full bg-red-100 sm:mx-0 sm:size-10">
                    <svg class="size-5 text-red-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.5" fill="none" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4v.01 0 0 " />
                    </svg>
                </div>
            @elseif($icon === 'Sucesso')
                <div class="mx-auto shrink-0 flex items-center justify-center size-12 rounded-full bg-blue-100 sm:mx-0 sm:size-10">
                    <svg class="size-5 text-secondary-blue" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            @else
                <div class="mx-auto shrink-0 flex items-center justify-center size-12 rounded-full bg-secondary-orange sm:mx-0 sm:size-10">
                    <x-lucide-alert-triangle class="text-white w-6 h-6" />
                </div>
            @endif
            <div class="mt-3 text-center sm:mt-0 sm:ms-4 sm:text-start">
                <h3 class="text-lg xl:text-xl font-semibold text-gray-800 dark:text-gray-200">
                    {{ $title }}
                </h3>
            </div>
        </div>
        <div class="mt-4 text-sm text-gray-600 dark:text-gray-400">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 bg-gray-100 dark:bg-gray-700/70 text-end transition">
        {{ $footer }}
    </div>
</x-modal>
