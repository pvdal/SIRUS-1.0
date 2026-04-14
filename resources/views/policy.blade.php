<x-guest-layout>
    <x-slot name="title">
        Políticas de privacidade
    </x-slot>
    <x-user-manual.navigation-menu/>
    <div class="py-2 bg-gray-100 dark:bg-gray-800">
        <div id="containerFuga" class="relative min-h-screen flex flex-col items-center pt-6 sm:pt-0">
            {{--
            <div class="w-full flex bg-primary-blue justify-center border border-gray-900 p-4 max-w-[1200px] mx-auto sm:rounded-t-lg">
                <x-authentication-card-logo size="60" />
            </div>
            --}}
            <div class="w-full max-w-6xl mx-auto lg:pt-28 pt-20 lg:p-24 md:p-20 sm:p-16 p-10
            bg-white dark:bg-gray-900 shadow-sm overflow-hidden sm:rounded-md
            prose
            prose-p:mb-2
            prose-ul:mt-2
            prose-ul:mb-3
            prose-li:my-1
            prose-headings:mb-4
            prose-headings:mt-6
            prose-headings:text-gray-900
            prose-p:text-gray-800
            prose-strong:text-gray-800
            dark:prose-li:text-gray-400
            dark:prose-headings:text-gray-200
            dark:prose-p:text-gray-300
            dark:prose-strong:text-gray-300">
                {!! $policy !!}

                {{--
                    <div>
                    <h1>Política de Privacidade - Sistema de Rubricas para Gestão Avaliação do SIMBAJU</h1>
                    <div class="flex flex-col">
                        <p class="font-medium text-foreground text-2xl !mb-0">Documento em desenvolvimento...</p>
                        <p class="text-lg">volte mais tarde.</p>
                    </div>
                </div>

                <!-- Div com botão fugitivo -->
                <button id="runBtn" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    Ver mais...
                </button>

                <script>
                    const runBtn = document.getElementById('runBtn');
                    const container = document.getElementById('containerFuga');

                    // Faz o botão “fugir” quando o mouse se aproxima
                    runBtn.addEventListener('mouseenter', () => {
                        const maxX = container.clientWidth - runBtn.offsetWidth;
                        const maxY = container.clientHeight - runBtn.offsetHeight;

                        // Calcula posição aleatória dentro da div container
                        const randomX = Math.floor(Math.random() * maxX);
                        const randomY = Math.floor(Math.random() * maxY);

                        runBtn.style.position = 'absolute';
                        runBtn.style.left = randomX + 'px';
                        runBtn.style.top = randomY + 'px';
                    });
                </script>
                <div class="mt-10 w-full bg-gray-800 h-12 rounded-lg"></div>
                --}}
            </div>
        </div>
    </div>
</x-guest-layout>
