<x-guest-layout>
    <div class="pt-4 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0 m-3">
            <div class="w-full flex bg-[var(--secondary-color)] justify-center border border-gray-900 p-4 max-w-[1800px] mx-auto">
                <x-authentication-card-logo />
            </div>

            <div class="w-full max-w-[1800px] mx-auto pt-20 lg:p-16 md:p-10 sm:p-2 bg-white shadow-md overflow-hidden sm:rounded-lg prose" >
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-guest-layout>
