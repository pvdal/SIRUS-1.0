<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if(config('accessibility.libras'))
                <div id="toggleVlibras" class="flex">
                    <x-secondary-button type="button" class="ms-auto space-x-2">
                        <x-lucide-hand class="w-5 h-5" />
                        <span id="btnTextLibras"></span>
                    </x-secondary-button>
                </div>
                <script>
                    const btnText = document.getElementById('btnTextLibras');
                    btnText.textContent = localStorage.getItem('vlibras_enabled') === 'true'
                        ? 'Desativar Libras'
                        : 'Ativar Libras';
                </script>
                <div x-data="{ vlActive: true }"
                     x-init="
                        vlActive = localStorage.getItem('vlibras_enabled') === 'true';
                        document.getElementById('toggleVlibras')?.remove();
                    "
                    class="flex"
                    x-cloak>
                    <!-- Botão para ativar/desativar -->
                    <x-secondary-button
                        type="button"
                        x-on:click="
                        $el.blur();
                        vlActive = !vlActive;
                        localStorage.setItem('vlibras_enabled', vlActive);
                        $dispatch('toggle-vlibras');
                    "
                        class="ms-auto space-x-2"
                    >
                        <x-lucide-hand class="w-5 h-5" />
                        <span x-text="vlActive ? 'Desativar Libras' : 'Ativar Libras'"></span>
                    </x-secondary-button>
                </div>
                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form') {{-- Alterado (My component is beign called instead of the Jetstream's default one)--}}

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-password-form')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.two-factor-authentication-form')
                </div>

                <x-section-border />
            @endif

            @if(config('fortify.manage-sessions'))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.logout-other-browser-sessions-form')
                </div>
            @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <x-section-border />

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
