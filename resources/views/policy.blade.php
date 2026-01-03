<x-guest-layout>
    <x-slot name="title">
        Políticas de privacidade
    </x-slot>
    <x-user-manual.navigation-menu/>
    <div class="py-2 bg-gray-100 dark:bg-gray-800">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            {{--
            <div class="w-full flex bg-primary-blue justify-center border border-gray-900 p-4 max-w-[1200px] mx-auto sm:rounded-t-lg">
                <x-authentication-card-logo size="60" />
            </div>
            --}}
            <div class="w-full max-w-6xl mx-auto lg:pt-28 pt-20 lg:p-24 md:p-20 sm:p-16 p-10 bg-white dark:bg-gray-900 shadow-sm overflow-hidden sm:rounded-md
            prose prose-headings:text-gray-900 prose-p:text-gray-800 prose-strong:text-gray-800 dark:prose-li:text-gray-400
            dark:prose-headings:text-gray-200 dark:prose-p:text-gray-300 dark:prose-strong:text-gray-300">
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-guest-layout>
