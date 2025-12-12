@php
    $links = [
        ['label' => '1. Introdução','page' => 'introduction'],
        ['label' => '2. Acesso ao Sistema','page' => 'access'],
        ['label' => '3. Segurança','page' => 'security'],
        ['label' => '4. Agenda de Avaliações','page' => 'calendar'],
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
        {{ request()->routeIs('manual.show') && request()->route('page') === $link['page'] ? 'bg-blue-50 text-blue-600 border border-blue-200 font-medium' : 'hover:bg-gray-100 text-gray-700' }}">
        <span>{{ $link['label'] }}</span>
        <x-lucide-chevron-right class="{{ request()->routeIs('manual.show') && request()->route('page') === $link['page'] ? 'text-blue-600 w-4 h-4' : 'hidden' }}"/>
    </a>
@endforeach
--}}
@foreach($links as $link)
    <a href="#{{ $link['page'] }}" class="chapter-link flex justify-between items-center px-3 py-2 rounded-lg border border-transparent transition hover:bg-gray-100 text-gray-700"
       data-target="{{ $link['page'] }}"
    >
        <span>{{ $link['label'] }}</span>
        <x-lucide-chevron-right class="chevron hidden w-4 h-4"/>
    </a>
@endforeach

<script>
    window.addEventListener("load", () => {
        const sections = document.querySelectorAll('.chapter');
        const links = document.querySelectorAll('.chapter-link');

        let lastScrollY = window.scrollY;

        function highlight(id) {
            links.forEach(link => {
                link.classList.remove('bg-blue-50', '!text-blue-600', 'border-blue-200', 'font-medium');
                link.classList.add('hover:bg-gray-100', 'text-gray-700');
                link.querySelector('.chevron').classList.add('hidden');

                if (link.dataset.target === id) {
                    link.classList.add('bg-blue-50', '!text-blue-600', 'border-blue-200', 'font-medium');
                    link.classList.remove('hover:bg-gray-100', 'text-gray-700');
                    link.querySelector('.chevron').classList.remove('hidden');
                }
            });
        }

        // Iniciando o destaque
        highlight("introduction");

        // DESCENDO
        const observerDown = new IntersectionObserver((entries) => {
            const goingDown = window.scrollY > lastScrollY;
            lastScrollY = window.scrollY;

            if (!goingDown) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    highlight(entry.target.id);
                }
            });
        }, {
            rootMargin: '-10% 0px -70% 0px',
            threshold: 0
        });

        // SUBINDO
        const observerUp = new IntersectionObserver((entries) => {
            const goingUp = window.scrollY < lastScrollY;
            lastScrollY = window.scrollY;

            if (!goingUp) return;

            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    highlight(entry.target.id);
                }
            });
        }, {
            rootMargin: '-70% 0px -10% 0px',
            threshold: 0
        });

        sections.forEach(section => {
            observerDown.observe(section);
            observerUp.observe(section);
        });
    });
</script>

