<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                @livewire('profile.update-profile-information-form') {{-- Alterado (My component is beign called instead of the Jetstream's default one)--}}

                <x-section-border />
            @endif

            @if(auth()->user()->professor || auth()->user()->coordinator)
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.update-education-form')
                </div>

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

                <x-section-border />
            @endif

            @if(config('accessibility.daltonism') || config('accessibility.libras'))
                <div class="mt-10 sm:mt-0">
                    @livewire('profile.manage-accessibility')
                </div>

                <x-section-border />
            @endif

            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())

                <div class="mt-10 sm:mt-0">
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
