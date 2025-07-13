<x-guest-layout>
    <x-slot name="title">
        Termos de uso
    </x-slot>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 m-3">
            <div class="w-full flex bg-[var(--secondary-color)] justify-center border border-gray-900 p-4 max-w-[1200px] mx-auto">
                <x-authentication-card-logo size="60" />
            </div>

            <div class="w-full max-w-[1200px] mx-auto lg:pt-28 pt-20 lg:p-24 md:p-20 sm:p-16 p-10 bg-white shadow-md overflow-hidden sm:rounded-lg prose" >
                {!! $terms !!}
            </div>
        </div>
    </div>
</x-guest-layout>
