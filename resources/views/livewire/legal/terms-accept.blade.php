<div>
    @if($show)
        <x-dialog-modal wire:modal="show">
            <x-slot name="title">
                Termos de uso e Políticas de privacidade
            </x-slot>
            <x-slot name="content">
                <p class="text-sm text-gray-600">
                    Para ter acesso ao sistema SIRUS é necessário aceitar os nossos Termos de Uso e Política de Privacidade.
                    Caso você não concorde, entre em contato com o nosso suporte e solicite a exclusão do seu cadastro.
                </p>

                <div class="mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox wire:model="accepted" id="terms" />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                        'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) !!}
                            </div>
                        </div>
                    </x-label>
                </div>
            </x-slot>
            <x-slot name="footer">
                <button
                    type="button"
                    wire:click="accept"
                    wire:loading.attr="disabled"
                    :disabled="!@js(!$accepted)"
                    class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600"
                >
                    Aceito os termos
                </button>
                <button
                    type="button"
                    wire:click="refuse"
                    class="px-4 py-2 ml-3 bg-red-500 text-white rounded hover:bg-red-600"
                >
                    Cancelar
                </button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
