@php
    $links = [
        ['label' => '1. Introdução','page' => 'introduction'],
        ['label' => '2. Acesso ao Sistema','page' => 'access'],
        ['label' => '3. Segurança','page' => 'security'],
        ['label' => '4. Agenda de Avaliações','page' => 'schedule'],
        ['label' => '5. Gerenciamento de Usuários','page' => 'users'],
        ['label' => '6. Configurações Institucionais','page' => 'institutional'],
        ['label' => '7. Critérios e Rubricas','page' => 'rubrics'],
        ['label' => '8. Processo de Avaliação','page' => 'evaluation'],
        ['label' => '9. Perfil','page' => 'profile'],
        ['label' => '10. Acessibilidade','page' => 'accessibility'],
        ['label' => '11. Suporte','page' => 'support']
    ];
@endphp
{{--
@foreach($links as $link)
    <a href="{{ route('manual.show', $link['page']) }}" class="flex justify-between items-center px-3 py-2 rounded-lg border border-transparent transition
        {{ request()->routeIs('manual.show') && request()->route('page') === $link['page'] ? 'bg-blue-50 dark:bg-blue-900/40 text-blue-600 dark:text-blue-300 border border-blue-200 font-medium' : 'hover:bg-gray-100 dark:hover:bg-slate-600 text-gray-700 dark:text-gray-200' }}">
        <span>{{ $link['label'] }}</span>
        <x-lucide-chevron-right class="{{ request()->routeIs('manual.show') && request()->route('page') === $link['page'] ? 'text-blue-600 w-4 h-4' : 'hidden' }}"/>
    </a>
@endforeach
--}}
@foreach($links as $link)
    <a href="#{{ $link['page'] }}" class="chapter-link flex justify-between items-center px-3 py-2 rounded-lg border border-transparent hover:bg-gray-100 text-gray-700
        dark:text-gray-200 transition duration-150 ease-in-out"
        data-target="{{ $link['page'] }}"
    >
        <span>{{ $link['label'] }}</span>
        <x-lucide-chevron-right class="chevron hidden w-4 h-4"/>
    </a>
@endforeach

<script>
    window.addEventListener("load", () => {
        {{-- seções da página e links do menu lateral --}}
        const sections = document.querySelectorAll('.chapter');
        const links = document.querySelectorAll('.chapter-link');
        {{-- função que adiciona destaque visual a um link do menu de navageção --}}
        function highlight(id) {
            {{-- O 'id ' aqui deve ser sempre uma das pages:'indtroduction','access'... --}}
            links.forEach(link => {
                {{-- O loop remove as classes de destaque de todos os links, exceto do que tem o data-target ==== 'id' passado como parâmetro --}}
                link.classList.remove('bg-blue-50', 'dark:!bg-blue-900/40', '!text-blue-600', 'dark:!text-blue-300', 'border-blue-200', 'font-medium');
                link.classList.add('hover:bg-gray-100', 'dark:hover:bg-slate-600');
                link.querySelector('.chevron').classList.add('hidden');

                if (link.dataset.target === id) {
                    link.classList.add('bg-blue-50', 'dark:!bg-blue-900/40', '!text-blue-600', 'dark:!text-blue-300', 'border-blue-200', 'font-medium');
                    link.classList.remove('hover:bg-gray-100', 'dark:hover:bg-slate-600');
                    link.querySelector('.chevron').classList.remove('hidden');
                }
            });
        }
        {{-- Inicializa o destaque --}}
        const initialHash = window.location.hash.replace('#','');
        if(initialHash) {
            highlight(initialHash);
        } else {
            highlight(sections[0].id);
        }
        {{-- A seção que cruza a linha do meio é considerada ativa o o link do menu é destacado --}}
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    highlight(entry.target.id);
                }
            });
        }, {
            rootMargin: "-50% 0px -50% 0px",
            threshold: 0
        });
        {{-- Aplica o observador a todas as seções --}}
        sections.forEach(section => observer.observe(section));
        {{-- Cada clique num link aplica a ele o destaque --}}
        links.forEach(link => {
            link.addEventListener('click', () => {
                highlight(link.dataset.target);
            });
        });
    });
</script>

