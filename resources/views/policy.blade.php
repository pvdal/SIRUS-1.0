<x-documentation-layout>
    <x-slot name="title">
        Políticas de privacidade
    </x-slot>
    <div class="py-2 bg-gray-100">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            {{--
            <div class="w-full flex bg-primary-blue justify-center border border-gray-900 p-4 max-w-[1200px] mx-auto sm:rounded-t-lg">
                <x-authentication-card-logo size="60" />
            </div>
            --}}
            <div class="w-full max-w-[1200px] mx-auto lg:pt-28 pt-20 lg:p-24 md:p-20 sm:p-16 p-10 bg-white shadow-md overflow-hidden sm:rounded-lg prose" >
                {!! $policy !!}
            </div>
        </div>
    </div>
</x-documentation-layout>
