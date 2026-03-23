<x-form-section submit="updateEducation">
    <x-slot name="title">
        {{ __('Formação') }}
    </x-slot>
    <x-slot name="description">
        {{ __('Informe suas principais formações acadêmicas. Esses dados serão utilizados para identificação de titulação em avaliações, bancas e relatórios do sistema.') }}
    </x-slot>
    <x-slot name="form">
        @foreach([
        'graduation' =>'Graduação',
        'specialization' => 'Especialização',
        'masters' => 'Mestrado',
        'doctorate' => 'Doutorado'
        ] as $level => $label)
            <div class="col-span-6 sm:col-span-4">
                <x-label for="{{ $level }}" :value="$label" />
                <x-input
                    id="{{ $level }}"
                    type="text"
                    class="mt-1 block w-full pe-8"
                    wire:model="education.{{ $level }}.course"
                />
            </div>
        @endforeach
    </x-slot>
    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            {{ __('Saved.') }}
        </x-action-message>
        <x-action-message class="me-3 text-red-600 dark:text-red-300" on="error">
            Espere duas horas antes de atualizar novamente.
        </x-action-message>

        <x-button>
            {{ __('Save') }}
        </x-button>
    </x-slot>
</x-form-section>
