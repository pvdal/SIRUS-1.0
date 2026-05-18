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
    @endphp
    {{-- Capítulos do manual: método de páginas múltiplas --}}
    <article id="{{ $chapter }}"
         class="chapter flex bg-white border border-white shadow px-8 py-12
            md:rounded-sm md:py-14 md:px-12 lg:py-20 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0
            text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-400
            lg:scroll-mt-[4rem]"
    >
        @include('user-manual.chapters.' . $chapter, [
            'textSettings' => $textSettings
        ])
    </article>
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
    @push('scripts')
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
    @endpush
</div>
