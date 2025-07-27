@props(['model'])

<div
    x-data
    x-show="{{ $attributes->get('x-model') }}"
    x-on:keydown.escape.window="{{ $attributes->get('x-model') }} = false"
    x-on:close-modal.window="{{ $attributes->get('x-model') }} = false"
    x-init="$watch('{{ $attributes->get('x-model') }}', value => {
        document.body.classList.toggle('overflow-hidden', value)
    })"
    x-cloak
>
    <!-- Backdrop -->
    <div
        class="fixed inset-0 z-40 bg-black bg-opacity-50"
        x-show="{{ $attributes->get('x-model') }}"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    ></div>

    <!-- Modal -->
    <div
        class="fixed inset-0 z-50 flex items-center justify-center px-4 sm:px-0"
        x-show="{{ $attributes->get('x-model') }}"
    >
        <div
            class="w-full max-w-2xl bg-white dark:bg-neutral-dark rounded-xl shadow-lg overflow-hidden"
            @click.away="{{ $attributes->get('x-model') }} = false"
            x-transition:enter="ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
        >
            <div class="px-6 py-4 border-b dark:border-gray-100">
                <h2 class="text-lg font-semibold text-gray-700">
                    {{ $title }}
                </h2>
            </div>

            <div class="px-6 py-4 mt-4 text-sm text-gray-600 ">
                {{ $content }}
            </div>
            @isset($footer)
                <div class="px-6 py-4 border-t dark:border-gray-100 text-end xxs:space-x-2">
                    {{ $footer }}
                </div>
            @endisset
        </div>
    </div>
</div>
{{--
 <div x-data="{ showModal: false }">
        <x-button @click="showModal = true">
            Abrir Modal
        </x-button>

        <x-custom-modal x-model="showModal">
            <x-slot name="title">
                Criar novo aluno
            </x-slot>

            <x-slot name="content">
                <x-banner />
                <x-form-fields.student typeModal="create" />
            </x-slot>

            <x-slot name="footer">
                <x-secondary-button
                    @click="$wire.resetForm('create').then(() => showModal = false)"
                >
                    Fechar
                </x-secondary-button>
                <x-danger-button @click="$wire.store()">
                    Salvar
                </x-danger-button>
            </x-slot>
        </x-custom-modal>
    </div>

 --}}
