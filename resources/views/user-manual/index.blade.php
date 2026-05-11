<x-guest-layout>
    {{-- Título da página --}}
    <x-slot name="title">
        Manual do Usuário
    </x-slot>

    {{-- Menu superior de navegação --}}
    <x-user-manual.navigation-menu/>

    {{-- Inicia contexto alpine --}}
    <div
        x-data="{
            stickyNav: localStorage.getItem('manual.sticky_nav') !== 'false',
            showChapterNav: localStorage.getItem('manual.show_chapter_nav') !== 'false',
            settings: false,

            fontSize: Number(localStorage.getItem('manual.font_size')) || 1,
            leadingHeight: Number(localStorage.getItem('manual.leading_height')) || 2,
            letterSpacing: Number(localStorage.getItem('manual.letter_spacing')) || 1,
            wordSpacing: Number(localStorage.getItem('manual.word_spacing')) || 1,

            init() {
                this.$watch('stickyNav', (value) => {
                    localStorage.setItem('manual.sticky_nav',value);
                });
                this.$watch('showChapterNav', (value) => {
                    localStorage.setItem('manual.show_chapter_nav',value);
                });

                this.$watch('fontSize', (value) => {
                    localStorage.setItem('manual.font_size',value);
                });
                this.$watch('leadingHeight', (value) => {
                    localStorage.setItem('manual.leading_height',value);
                });
                this.$watch('letterSpacing', (value) => {
                    localStorage.setItem('manual.letter_spacing',value);
                });
                this.$watch('wordSpacing', (value) => {
                    localStorage.setItem('manual.word_spacing',value);
                });
            }
        }"
        x-init="init()"
        class="flex flex-1 flex-col w-full min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-800 text-gray-900"
    >
        {{-- Container principal --}}
        <div class="flex flex-1 flex-col w-full max-w-[1800px] min-h-full  mx-auto md:px-2 gap-2 lg:flex-row">
            {{-- Menu lateral --}}
            <aside class="w-full lg:w-1/4">
                <div class="flex flex-col bg-white dark:bg-gray-900 shadow
                    lg:h-[calc(100vh-64px)] sticky top-[64px]
                    pb-10 lg:pb-2 pt-5
                    border border-white dark:border-gray-900
                    rounded-b-md lg:rounded-sm">
                    <div class="flex items-center mb-4 px-4 text-gray-800 dark:text-gray-100">
                        <div id="manual-heading" class="flex flex-col me-auto">
                            <h1 class="text-lg font-semibold me-auto">Manual do Usuário</h1>
                        </div>

                        <button
                            x-on:click="settings = !settings"
                            class="hover:bg-gray-200 dark:hover:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-md p-2">
                            <x-lucide-settings-2 class="h-4 w-4"/>
                        </button>
                    </div>
                    <hr x-show="!settings" class="border-gray-100 dark:border-gray-700 mx-2">
                    {{-- Navegação entre capítulos --}}
                    <nav x-show="!settings" class="flex-1 overflow-y-auto scrollbar-custom
                        space-y-1 px-4 py-2 lg:h-[calc(100vh-80px-48px-34px)]">
                        <x-user-manual.manual-chapters/>
                    </nav>
                    {{-- Configuração de tipografia --}}
                    <div x-cloak x-show="settings">
                        <x-user-manual.settings/>
                    </div>
                    <div class="flex justify-start px-2 pt-3">
                        <span
                            class="inline-flex px-3 py-1 rounded-lg text-xs lg:text-sm font-light text-gray-600
                            dark:text-gray-400 "
                        >
                            Última atualização: 11/05/2026
                        </span>
                    </div>
                </div>
            </aside>

            <div class="w-full lg:w-3/4">
                {{-- Conteúdo do manual --}}
                <main>
                    <x-user-manual.content/>
                </main>
                {{-- Rodapé --}}
                <footer class="mt-2 bg-transparent text-white border-t border-gray-200 dark:border-gray-700">
                    <div class="max-w-[2100px] mx-auto px-4 py-6 sm:px-6 lg:px-8">
                        <div class="flex flex-col gap-4 items-center justify-center">
                            <div class="space-y-1 text-gray-800 dark:text-gray-300">
                                <p class="text-base text-center">
                                    Manual do Usuário
                                </p>
                                <!-- Copyright -->
                                <p class="text-sm text-center">
                                    &copy; <strong>SIRUS –</strong> Sistema de Rubricas para Gestão avaliativa do SIMBAJU
                                </p>
                                <p class="text-xs text-center">
                                    Versão 1.3.3 | 2026
                                </p>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
    </div>

    {{-- Botão de voltar ao topo --}}
    <x-back-to-top-button />

    {{-- Inicia o estado da tipografia e layout, evitando o flash de texto desconfigurado entre a renderização do HTML e a inicialização do Alpine --}}
    <script>
        (() => {
            const fontSize = Number(localStorage.getItem('manual.font_size')) || 1;
            const leadingHeight = Number(localStorage.getItem('manual.leading_height')) || 2;
            const letterSpacing = Number(localStorage.getItem('manual.letter_spacing')) || 1;
            const wordSpacing = Number(localStorage.getItem('manual.word_spacing')) || 1;

            const sn = localStorage.getItem('manual.sticky_nav') !== 'false';
            const cn = localStorage.getItem('manual.show_chapter_nav') !== 'false';

            const mapFont = {
                1: 'text-base',
                2: 'text-lg',
                3: 'text-xl',
            };

            const mapLeading = {
                1: 'leading-normal',
                2: 'leading-relaxed',
                3: 'leading-loose',
                4: '[line-height:2.2]',
            };

            const mapLetterSpacing = {
                1: 'tracking-normal',
                2: 'tracking-wide',
                3: 'tracking-wider',
                4: 'tracking-widest',
            };

            const mapWordSpacing = {
                1: '[word-spacing:0]',
                2: '[word-spacing:0.05em]',
                3: '[word-spacing:0.1em]',
                4: '[word-spacing:0.2em]',
            };
            {{-- Tipografia --}}
            document.querySelectorAll('.chapter').forEach(el => {
                el.classList.add(
                    mapFont[fontSize],
                    mapLeading[leadingHeight],
                    mapLetterSpacing[letterSpacing],
                    mapWordSpacing[wordSpacing]
                );
            });
            {{-- Visualização da sideBar --}}
            if(!cn) {
                document.querySelectorAll('.chapter-aside').forEach(el => {
                    el.classList.add('hidden-chapter-aside');
                });
            }
            {{-- Fixação da sideBar --}}
            if(sn) {
                document.querySelectorAll('.chapter-aside').forEach(el => {
                    el.classList.add('sticky-chapter-aside');
                });
            }
        })();
    </script>
</x-guest-layout>
