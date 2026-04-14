<x-guest-layout>
    <x-slot name="title">
        Termos de uso
    </x-slot>
    <x-user-manual.navigation-menu/>
    <div class="py-2 bg-gray-100 dark:bg-gray-800">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            {{--
            <div class="w-full flex bg-primary-blue justify-center border border-gray-900 p-4 max-w-[1200px] mx-auto sm:rounded-t-lg">
                <x-authentication-card-logo size="60" />
            </div>
            --}}
            <div class="w-full max-w-6xl mx-auto lg:pt-28 pt-20 lg:p-24 md:p-20 sm:p-16 p-10
            bg-white dark:bg-gray-900 shadow-sm overflow-hidden sm:rounded-md
            prose
            prose-p:mb-2
            prose-ul:mt-2
            prose-ul:mb-3
            prose-li:my-1
            prose-headings:mb-4
            prose-headings:mt-6
            prose-headings:text-gray-900
            prose-p:text-gray-800
            prose-strong:text-gray-800
            dark:prose-li:text-gray-400
            dark:prose-headings:text-gray-200
            dark:prose-p:text-gray-300
            dark:prose-strong:text-gray-300
            dark:prose-a:text-gray-300">
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
