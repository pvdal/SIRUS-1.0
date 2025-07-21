<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo size="60"/>
        </x-slot>

        <div class="mb-4 text-sm text-gray-600 text-justify">
            {{ __('Antes de continuar, por favor verifique seu endereço de e-mail. Para isso, clique no botão "Enviar o e-mail de verificação" abaixo, assim, enviaremos um e-mail com o link de verificação. Caso já tenha solicitado, mas não tenha recebido o e-mail, você pode reenviá-lo.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ __('Um novo link de verificação foi enviado para o endereço de e-mail que você cadastrou nas configurações do perfil.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-button type="submit">
                        {{ __('Enviar o e-mail de verificação') }}
                    </x-button>
                </div>
            </form>

            <div>

                  <a
                        href="{{ route('profile.show') }}"
                        class="underline text-sm text-gray-600 me-2 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-blue"
                    >
                        {{ __('Editar perfil') }}</a>



                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf

                    <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-secondary-blue">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
