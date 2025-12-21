<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    <x-slot name="title">
        Manual do usuário
    </x-slot>
    {{-- Seção 1 --}}
    <article id="introduction" class="relative flex chapter bg-white shadow-sm md:rounded-md border border-white px-8 py-12 lg:p-16 lg:ps-24 lg:pt-20 xl:pe-0 text-gray-800 dark:bg-gray-900 dark:border-gray-900  dark:text-gray-300 lg:scroll-mt-[4.5rem]">
        <div class="max-w-4xl w-full xl:pe-24 ">
            {{-- Capítulo 1 --}}
            <h1 id="cap-1" class="text-3xl font-bold mb-12 text-gray-900 dark:text-gray-100">1. Introdução</h1>

            {{-- Capítulo 1.1 --}}
            <h2 id="cap-1.1" class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.1 Sobre o Sistema</h2>
            <p class="leading-relaxed mb-4">
                O <strong>SIRUS (Sistema de Rubricas para Gestão Avaliativa do SIMBAJU)</strong>
                é uma plataforma web desenvolvida com o propósito de otimizar e padronizar o processo
                de avaliação acadêmica dos trabalhos apresentados no <strong>SIMBAJU.</strong>
                A solução propõe a centralização das informações avaliativas, a organização dos critérios
                de desempenho e a uniformização das rubricas utilizadas pelas bancas, proporcionando maior
                clareza, objetividade e confiabilidade ao processo avaliativo, tanto para avaliadores quanto para alunos.
            </p>
            <h3 class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Objetivos Principais</h3>
            <ul class="list-disc pl-6 space-y-1 mb-10">
                <li>Centralizar o gerenciamento das avaliações acadêmicas em uma única plataforma</li>
                <li>Padronizar critérios, rubricas e métodos de atribuição de notas</li>
                <li>Facilitar a organização e o acompanhamento das bancas avaliativas e dos grupos avaliados</li>
                <li>Organizar e disponibilizar dados de alunos, professores e coordenadores de forma estruturada</li>
                <li>Fornecer registros, análises e relatórios que apoiem a tomada de decisão e o feedback aos alunos</li>
            </ul>

            {{-- Capítulo 1.2 --}}
            <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.2 Público-Alvo</h2>
            <p class="leading-relaxed mb-2">
                O sistema foi projetado para os seguintes usuários
            </p>
            <ul class="list-disc pl-6 space-y-1 mb-10 text-gray-800 dark:text-gray-300">
                <li><strong>Coordenadores acadêmicos:</strong> Gerenciam toda a plataforma</li>
                <li><strong>Professores e avaliadores:</strong> Realizam avaliações de alunos</li>
                <li><strong>Alunos (organizados em grupos):</strong> Participam de avaliações e acompanham resultados</li>
            </ul>

            {{-- Capítulo 1.3 --}}
            <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.3 Sobre o SIMBAJU</h2>
            <p class="leading-relaxed mb-10">
                O <strong>SIMBAJU (Simpósio da Bacia do Juquery)</strong> é um evento acadêmico-científico realizado semestralmente
                na Faculdade de Tecnologia de Franco da Rocha, no estado de São Paulo. A instituição de ensino superior
                promove, com a apresentação dos trabalhos dos alunos, uma troca de conhecimento entre alunos e
                especialistas, ajudando os participantes e ouvintes a terem uma formação mais sólida na área em um ambiente
                de inovação. Para mais informações, visite o site da instituição:
                <a
                    target="_blank"
                    rel="noopener noreferrer"
                    href="https://fatecfrancodarocha.cps.sp.gov.br/simbaju/"
                    class="text-secondary-blue dark:text-blue-400 font-medium hover:underline break-all md:break-normal"
                >https://fatecfrancodarocha.cps.sp.gov.br/simbaju/</a>.
            </p>

            {{-- Capítulo 1.4 --}}
            <h2 class="text-xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.4 Sobre este Manual do Usuário</h2>
            <h3 class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Finalidade do Manual</h3>
            <p class="leading-relaxed mb-4">
                Este manual do usuário tem como objetivo orientar os usuários do sistema SIRUS na utilização correta
                e eficiente de suas funcionalidades. O documento apresenta, de forma clara e organizada, as principais
                operações disponíveis na plataforma, considerando os diferentes perfis de acesso existentes.
            </p>
            <h3 class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Conteúdo Abordado</h3>
            <p class="leading-relaxed mb-4">
                Ao longo do manual, são descritos os procedimentos necessários para navegação no sistema, realização
                de cadastros, acompanhamento das bancas avaliativas, visualização de trabalhos e registro ou consulta
                das avaliações, conforme as permissões de cada tipo de usuário.
            </p>
            <h3 class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Público e Objetivo de Uso</h3>
            <p class="leading-relaxed">
                O conteúdo foi elaborado com foco na usabilidade e na compreensão prática do sistema, servindo como
                material de apoio tanto para novos usuários quanto para aqueles que já utilizam a plataforma,
                contribuindo para a padronização dos processos e para o uso adequado das funcionalidades disponibilizadas.
            </p>
        </div>
        <aside class="hidden xl:block sticky top-[150px] self-start text-sm px-5 min-w-60 xl:border-l border-gray-300 dark:border-gray-700">
            <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
                Neste capítulo
            </h2>
            <nav class="leading-relaxed space-y-2 text-gray-600 dark:text-gray-400">
                <a href="#cap-1.1" class="grid grid-cols-[auto_1fr] gap-x-1 cursor-pointer">
                    <span class="font-semibold">1.1</span>
                    <span>Sobre o sistema</span>
                </a>

                <div class="grid grid-cols-[auto_1fr] gap-x-1 pl-4">
                    <span>Objetivos Principais</span>
                </div>

                <div class="grid grid-cols-[auto_1fr] gap-x-1">
                    <span class="font-semibold">1.2</span>
                    <span>Público-Alvo</span>
                </div>
                <div class="grid grid-cols-[auto_1fr] gap-x-1">
                    <span class="font-semibold">1.3</span>
                    <span>Sobre o SIMBAJU</span>
                </div>
                <div class="grid grid-cols-[auto_1fr] gap-x-1">
                    <span class="font-semibold">1.4</span>
                    <span>Sobre este Manual do Usuário</span>
                </div>

                <div class="grid grid-cols-[auto_1fr] gap-x-1 pl-4">
                    <span>Finalidade do Manual</span>
                </div>
                <div class="grid grid-cols-[auto_1fr] gap-x-1 pl-4">
                    <span>Conteúdo Abordado</span>
                </div>
                <div class="grid grid-cols-[auto_1fr] gap-x-1 pl-4">
                    <span>Público e Objetivo de Uso</span>
                </div>
            </nav>
        </aside>
    </article>
    {{-- Rodapé --}}
    <footer class="mt-5 bg-transparent text-white border-t border-gray-200 dark:border-gray-700">
        <div class="max-w-[2100px] mx-auto px-4 py-6 sm:px-6 lg:px-8">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-center">
                <div class="flex flex-col items-center">
                    <div class="space-y-1 text-gray-800 dark:text-gray-300">
                        <p class="text-base text-center">
                            Manual do Usuário
                        </p>
                        <!-- Copyright -->
                        <p class="text-sm text-center">
                            &copy; <strong>SIRUS –</strong> Sistema de Rubricas para Gestão avaliativa do SIMBAJU
                        </p>
                        <p class="text-xs text-center">
                            Versão 1.0 | 2025
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</x-documentation-layout>
