<div>
    @if($show)
        <x-dialog-modal wire:modal="show">
            <x-slot name="title">
                <h1 class="md:mx-4 mt-6 text-xl font-bold text-gray-900 dark:text-gray-100">
                    Termos de uso e Política de privacidade
                </h1>
            </x-slot>
            <x-slot name="content">
                <p class="md:mx-4 mb-2 text-base text-gray-700 dark:text-gray-300">
                    Para ter acesso ao sistema SIRUS é necessário aceitar os nossos Termos de Uso e Política de Privacidade.
                    Esses documentos explicam como o sistema deve ser utilizado e garantem segurança e respaldo legal
                    para você e para a instituição.
                </p>
                <p class="md:mx-4 text-base text-gray-700 dark:text-gray-300">
                    Caso você não concorde, entre em contato com o nosso suporte e solicite a exclusão do seu cadastro.
                    Ao clicar em "Cancelar", você será desconectado do sistema e precisará realizar nova autenticação caso
                    queira acessá-lo novamente.
                </p>

                <div class="md:mx-4 mt-4">
                    <x-label for="terms">
                        <div class="flex items-center">
                            <x-checkbox wire:model="accepted" id="terms" />

                            <div class="ms-2">
                                {!! __('I agree to the :terms_of_use and :privacy_policy', [
                                        'terms_of_use' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-secondary-blue dark:text-blue-300 hover:text-royal-blue dark:hover:text-blue-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-secondary-blue">'.__('Terms of Service').'</a>',
                                        'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-secondary-blue dark:text-blue-300 hover:text-royal-blue dark:hover:text-blue-400 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 dark:focus:ring-offset-gray-800 focus:ring-secondary-blue">'.__('Privacy Policy').'</a>',
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
                    class="px-4 py-2 bg-secondary-blue text-white rounded hover:opacity-90"
                >
                    Aceitar e continuar
                </button>
                <button
                    type="button"
                    wire:click="refuse"
                    class="px-4 py-2 ml-3 bg-danger-orange text-white rounded hover:opacity-90"
                >
                    Cancelar
                </button>
            </x-slot>
        </x-dialog-modal>
    @endif
</div>
