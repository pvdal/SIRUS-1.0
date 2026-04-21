<div>
    {{-- Configuração do texto --}}
    @php
        $textSettings = "
            'text-base': fontSize === 1,
            'text-lg': fontSize === 2,
            'text-xl': fontSize === 3,

            'leading-normal': leadingHeight === 1,
            'leading-relaxed': leadingHeight === 2,
            'leading-loose': leadingHeight === 3,
            '[line-height:2.2]': leadingHeight === 4,

            'tracking-normal': letterSpacing === 1,
            'tracking-wide': letterSpacing === 2,
            'tracking-wider': letterSpacing === 3,
            'tracking-widest': letterSpacing === 4,

            '[word-spacing:0]': wordSpacing === 1,
            '[word-spacing:0.05em]': wordSpacing === 2,
            '[word-spacing:0.1em]': wordSpacing === 3,
            '[word-spacing:0.2em]': wordSpacing === 4,
        ";

        $chapters = [
            'introduction',
            'access',
            'security',
            'schedule',
            'users',
            'institutional',
            'rubrics-evaluation',
            'paper',
            'profile',
            'accessibility',
            'api-tokens'
        ];
    @endphp
    {{-- Capítulos do manual --}}
    <div class="space-y-2">

        @foreach($chapters as $chapter)
            <!-- Capítulo {{ $loop->iteration }} -->
            @if(
                ($loop->iteration === 5 || $loop->iteration === 8 || $loop->iteration === 11)
                && !auth()->user()->isAdmin()
            )
            @else
            <article id="{{ $chapter }}" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-12 md:py-14 md:px-12 lg:py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
                <x-dynamic-component :component="'user-manual.chapters.' . $chapter" :text-settings="$textSettings"/>
            </article>
            @endif
        @endforeach

        {{-- Seção 11
        <article id="support" class="chapter flex bg-white shadow md:rounded-sm border border-white px-8 py-12 md:py-14 md:px-12 lg:py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400 lg:scroll-mt-[4rem]">
            <div class="max-w-4xl w-full xl:pe-24">
                <h1 class="text-3xl mb-8 font-bold">11. Suporte</h1>
                <hr class="border-gray-200 dark:border-gray-700 mb-10">

                <h1 class="text-xl font-bold mb-4">Perguntas Frequentes</h1>
                <div class="space-y-4 mb-4 text-gray-800 dark:text-gray-300">
                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Esqueci minha senha. O que fazer?</h3>
                        <p>Contate o administrador do sistema para resetar sua senha. Você receberá um e-mail com instruções.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Não consigo fazer login</h3>
                        <p>Verifique se o e-mail e a senha estão corretos. Confira se está utilizando as credenciais fornecidas pelo administrador.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">A página não carrega</h3>
                        <p>Atualize o navegador (F5) ou limpe o cache. Se o problema persistir, tente outro navegador.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Erro ao salvar avaliação</h3>
                        <p>Verifique sua conexão com a internet. Caso persista, anote o código do erro e contate o suporte.</p>
                    </div>

                    <div class="border-l-4 border-blue-600 pl-4 py-2">
                        <h3 class="font-semibold mb-1">Não vejo os alunos no meu grupo</h3>
                        <p>Confirme se o grupo foi criado e se os alunos foram atribuídos corretamente. Em caso de dúvidas, procure o administrador.</p>
                    </div>
                </div>

                <!-- Seção 2: Contato e Suporte -->
                <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
                    <h1 class="text-xl font-bold mb-4">Contato e Suporte</h1>
                    <p class="leading-relaxed mb-6 text-gray-800 dark:text-gray-300">
                        Para dúvidas ou problemas técnicos, entre em contato através dos canais abaixo:
                    </p>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="font-semibold text-blue-900 flex items-center gap-2 mb-2">
                                📧 E-mail
                            </h3>
                            <p class="text-blue-800">suporte@institucao.edu.br</p>
                        </div>

                        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                            <h3 class="font-semibold text-green-900 flex items-center gap-2 mb-2">
                                📞 Telefone
                            </h3>
                            <p class="text-green-800">(XX) XXXX-XXXX</p>
                        </div>

                        <div class="bg-purple-50 border border-purple-200 rounded-lg p-4">
                            <h3 class="font-semibold text-purple-900 flex items-center gap-2 mb-2">
                                🏢 Presencialmente
                            </h3>
                            <p class="text-purple-800">Sala de TI - Bloco A, 2º andar</p>
                        </div>

                        <div class="bg-orange-50 border border-orange-200 rounded-lg p-4">
                            <h3 class="font-semibold text-orange-900 flex items-center gap-2 mb-2">
                                ⏰ Horário de Atendimento
                            </h3>
                            <p class="text-orange-800">Segunda a Sexta, 8h às 18h</p>
                        </div>
                    </div>
                </article>

                <h1 class="text-xl font-bold mb-4">Glossário de Termos</h1>
                <div class="space-y-4 text-gray-800 dark:text-gray-300">
                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Banca</strong>
                        <p class="text-sm">Grupo de avaliadores responsável por avaliar grupos/alunos.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Rubrica</strong>
                        <p class="text-sm">Conjunto de critérios e eixos utilizados para avaliar desempenho.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Eixo</strong>
                        <p class="text-sm">Agrupamento temático de critérios relacionados.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Critério</strong>
                        <p class="text-sm">Aspecto específico do desempenho avaliado.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>RA</strong>
                        <p class="text-sm">Registro Acadêmico – identificação única do aluno.</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Estado</strong>
                        <p class="text-sm">Situação do usuário no sistema (Ativo/Inativo).</p>
                    </div>

                    <div class="border-l-4 border-gray-300 pl-4">
                        <strong>Modal</strong>
                        <p class="text-sm">Janela sobreposta utilizada para exibir formulários ou ações rápidas.</p>
                    </div>
                </div>
            </div>
            <div class="hidden xl:block text-sm px-5 min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky top-[86px] self-start': stickyNav, '!hidden': !showChapterNav }">
                <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                    Neste capítulo
                </h2>
                <div class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.1</span>
                        <span>Sobre o sistema</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Objetivos Principais</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.2</span>
                        <span>Público-Alvo</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.3</span>
                        <span>Sobre o SIMBAJU</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2">
                        <span class="font-medium">1.4</span>
                        <span>Sobre este Manual do Usuário</span>
                    </div>

                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Finalidade do Manual</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Conteúdo Abordado</span>
                    </div>
                    <div class="grid grid-cols-[auto_1fr] gap-x-2 pl-4">
                        <span>Público e Objetivo de Uso</span>
                    </div>
                </div>
            </div>
        </article>--}}
    </div>
    {{-- Atribui scroll margin a todos os títulos, e estilização de navegação interna --}}
    <style>
        article.chapter h2,
        article.chapter h3,
        article.chapter h4 {
            scroll-margin-top: 4.5rem;
        }

        .chapter-aside h2,
        .chapter-aside nav a {
            padding: 0 1.25rem; /* 20px */
            border-left: transparent solid 2px;
        }
        .chapter-aside nav a:hover {
            border-left: #6b7280 solid 2px;
        }
        .chapter-aside nav a.active {
            padding: 0 1.25rem; /* 20px */
            border-left: #4169E1 solid 2px;
        }
    </style>
    {{-- Padroniza estruturas do menu aside dos capitulos --}}
    <style>
        .hidden-chapter-aside {
            display: none !important;
        }
        .sticky-chapter-aside {
            position: sticky;
            top: 86px;
            align-self: start;
        }
    </style>
    {{-- Controla paginação interna dos capítulos --}}
    <script>
        window.addEventListener("load", () => {
            const sections = [...document.querySelectorAll('[id^="cap-"]')];
            const links = document.querySelectorAll('.sub-chapter-link');

            let lockScroll = false;

            function highlight(id) {
                links.forEach(link => {
                    link.classList.toggle(
                        'active',
                        link.getAttribute('href') === `#${id}`
                    );
                });
            }

            const observer = new IntersectionObserver(
                (entries) => {
                    if (lockScroll) return;

                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            highlight(entry.target.id);
                        }
                    });
                },
                {
                    root: null,
                    // cria uma "linha" a 150px do topo
                    rootMargin: '-25% 0px -75% 0px',
                    threshold: 0
                }
            );

            sections.forEach(section => observer.observe(section));

            links.forEach(link => {
                link.addEventListener('click', () => {
                    const id = link.getAttribute('href').replace('#', '');

                    lockScroll = true;
                    highlight(id);

                    setTimeout(() => {
                        lockScroll = false;
                    }, 120);
                });
            });
        });
    </script>
</div>
