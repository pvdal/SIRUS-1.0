@props([
    'title',
    'downloadRoute',
    'importRoute',
    'loadFunction' => null
])

<div
    x-show="showImportModal"
    x-cloak
    x-init="$watch('showImportModal', value => { if (value) $refs.fileInput.value = '' })"
    class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
>
    <div @click.outside="showImportModal = false" class="bg-white dark:bg-gray-800 p-8 rounded-xl shadow-2xl max-w-md w-full">
        <h2 class="text-2xl font-bold mb-4 text-gray-800 dark:text-white">{{ $title }}</h2>

        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
            Para importar, utilize nosso modelo padrão para evitar erros de leitura.
            <a href="{{ $downloadRoute }}" class="text-blue-500 font-bold block mt-2 underline">
                Baixar Modelo Excel
            </a>
        </p>

        <form action="{{ $importRoute }}" method="POST" enctype="multipart/form-data"
              @submit="
                window.dispatchEvent(new CustomEvent('banner-message', {
                    detail: { style: 'info', message: 'Importação em andamento... Gerando relatório.' }
                }));

                {{-- O segredo para o banner sumir depois: --}}
                setTimeout(() => {
                    @if($loadFunction) {{ $loadFunction }}; @endif
                    showImportModal = false;

                    {{-- Dispara um fechamento automático do banner após 5 segundos se for 'info' --}}
                    setTimeout(() => {
                        window.dispatchEvent(new CustomEvent('banner-message', { detail: { message: false } }));
                    }, 5000);
                }, 1000);
              ">
            @csrf
            <div class="mb-4">
                <input type="file" name="file" x-ref="fileInput" required
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
            </div>

            <div class="flex justify-end space-x-3">
                <button type="button" @click="showImportModal = false" class="px-4 py-2 text-gray-500 hover:bg-gray-100 rounded">
                    Cancelar
                </button>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Iniciar Importação
                </button>
            </div>
        </form>
    </div>
</div>
