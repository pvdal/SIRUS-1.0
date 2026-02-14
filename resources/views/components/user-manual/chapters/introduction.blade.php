<div class="max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 1 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">1. Introdução</h1>

    {{-- Capítulo 1.1 --}}
    <h2 id="cap-1.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.1 Sobre o Sistema</h2>
    <p class="mb-4">
        O <strong>SIRUS (Sistema de Rubricas para Gestão Avaliativa do SIMBAJU)</strong>
        é uma plataforma web desenvolvida com o propósito de otimizar e padronizar o processo
        de avaliação acadêmica dos trabalhos apresentados no <strong>SIMBAJU.</strong>
        A solução propõe a centralização das informações avaliativas, a organização dos critérios
        de desempenho e a uniformização das rubricas utilizadas pelas bancas, proporcionando maior
        clareza, objetividade e confiabilidade ao processo avaliativo, tanto para avaliadores quanto para alunos.
    </p>

    <h3 id="cap-1.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Objetivos Principais</h3>
    <ul class="list-disc pl-6 space-y-1 mb-10">
        <li>Centralizar o gerenciamento das avaliações acadêmicas em uma única plataforma</li>
        <li>Padronizar critérios, rubricas e métodos de atribuição de notas</li>
        <li>Facilitar a organização e o acompanhamento das bancas avaliativas e dos grupos avaliados</li>
        <li>Organizar e disponibilizar dados de alunos, professores e coordenadores, relacionados ao evento, de forma estruturada</li>
        <li>Fornecer registros, análises e relatórios que apoiem a tomada de decisão e o feedback aos alunos</li>
    </ul>

    {{-- Capítulo 1.2 --}}
    <h2 id="cap-1.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.2 Público-Alvo</h2>
    <p class="mb-2">
        O sistema foi projetado para atender às demandas do SIMBAJU, portanto, destina-se aos envolvidos nas
        atividades relacionadas ao evento, sendo eles:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-10 text-gray-800 dark:text-gray-300">
        <li><strong>Coordenadores acadêmicos:</strong> gerenciam toda a plataforma, podendo também atuar como avaliadores</li>
        <li><strong>Professores e avaliadores:</strong> realizam as avaliações dos trabalhos acadêmicos dos alunos</li>
        <li>
            <strong>Alunos (organizados em grupos):</strong> participam de avaliações, tendo seus trabalhos e apresentações submetidos à avaliação,
            e acompanham seus resultados
        </li>
    </ul>

    {{-- Capítulo 1.3 --}}
    <h2 id="cap-1.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">1.3 Sobre o SIMBAJU</h2>
    <p class="mb-10">
        O <strong>SIMBAJU (Simpósio da Bacia do Juquery)</strong> é um evento acadêmico-científico realizado semestralmente
        na Faculdade de Tecnologia de Franco da Rocha, no estado de São Paulo. A instituição de ensino superior
        promove, com a apresentação dos trabalhos dos alunos, uma troca de conhecimento entre alunos e
        especialistas, ajudando os participantes e ouvintes a terem uma formação mais sólida na área em um ambiente
        de inovação. Para mais informações, visite o site da instituição:
        <a
            target="_blank"
            rel="noopener noreferrer"
            href="https://fatecfrancodarocha.cps.sp.gov.br/simbaju/"
            class="text-secondary-blue dark:text-blue-400 font-medium hover:underline break-all xl:break-normal"
        >https://fatecfrancodarocha.cps.sp.gov.br/simbaju/</a>.
    </p>

    {{-- Capítulo 1.4 --}}
    <h2 id="cap-1.4" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">1.4 Sobre este Manual do Usuário</h2>

    <h3 id="cap-1.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Finalidade do Manual</h3>
    <p class="mb-4">
        Este manual do usuário tem como objetivo orientar os usuários do sistema SIRUS na utilização correta
        e eficiente de suas funcionalidades. O documento apresenta as principais operações disponíveis na plataforma,
        considerando os diferentes perfis de acesso existentes.
    </p>

    <h3 id="cap-1.4-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Conteúdo Abordado</h3>
    <p class="mb-4">
        Ao longo do manual, são descritos os procedimentos necessários para navegação no sistema, realização
        de cadastros, acompanhamento das bancas avaliadoras, visualização de trabalhos e registro ou consulta
        das avaliações, conforme as permissões de cada tipo de usuário.
    </p>

    <h3 id="cap-1.4-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Público e Objetivo de Uso</h3>
    <p class="mb-8">
        O conteúdo foi elaborado com foco na usabilidade e na compreensão prática do sistema, servindo como
        material de apoio tanto para novos usuários quanto para aqueles que já utilizam a plataforma,
        contribuindo para a padronização dos processos e para o uso adequado das funcionalidades disponibilizadas.
    </p>

    {{-- Capítulo 1.4.1 --}}
    <h2 id="cap-1.4.1" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">1.4.1 Navegação</h2>

    <h3 id="cap-1.4.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação do manual</h3>
    <p class="mb-2">
        O Manual do Usuário possui um menu de navegação que se adapta conforme o tamanho da tela do
        dispositivo utilizado. Em tela maiores é visível na lateral esquerda da página, em telas menores,
        é visível logo no início, antes de qualquer capítulo. Seu objetivo é possibilitar acesso rápido aos
        capítulos deste manual.
    </p>
    <p class="mb-4">
        No topo desse menu é exibido o título <strong>"Manual do Usuário"</strong>, acompanhado
        de um ícone de configurações.
        Abaixo do título, encontra-se a lista de capítulos do manual. O capítulo atualmente
        selecionado permanece destacado, permitindo ao usuário identificar facilmente
        sua posição no conteúdo.
    </p>

    <h3 id="cap-1.4.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Navegação do capítulo</h3>
    <p class="mb-4">
        A navegação interna entre seções dos capítulos é disponibilizada apenas em telas com largura a partir
        de <strong>1280 pixels</strong>. Nessa resolução, o controle de sua exibição e layout encontra-se
        disponível no painel de preferências.
    </p>

    <h3 id="cap-1.4.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Voltar ao topo</h3>
    <p class="mb-8">
        Para facilitar a navegação, especialmente em dispositivos móveis onde não há um menu lateral fixo,
        o manual disponibiliza um botão de retorno ao topo da página, localizado no canto inferior direito da tela.
    </p>

    {{-- Capítulo 1.4.2 --}}
    <h2 id="cap-1.4.2" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">1.4.2 Preferências de leitura</h2>
    <p class="mb-4">
        Ao clicar no ícone de configurações, localizado no topo do menu de navegação, é exibido
        o painel <strong>"Preferências de leitura"</strong>. Esse painel permite personalizar
        a forma como o conteúdo do manual é apresentado, de acordo com as preferências
        individuais de leitura.
    </p>

    <h3 id="cap-1.4.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Restaurar configurações</h3>
    <p class="mb-4">
        No cabeçalho do painel de preferências, está disponível o botão <strong>Restaurar</strong>,
        que permite redefinir todas as configurações de leitura para os valores padrão.
    </p>

    <h3 id="cap-1.4.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Opções disponíveis</h3>
    <ul class="list-disc pl-6 space-y-2 mb-4">
        <li>
            <strong>Navegação do capítulo:</strong> permite exibir ou ocultar o controle de navegação
            interna entre seções do capítulo.
        </li>
        <li>
            <strong>Tamanho da fonte:</strong> possibilita ajustar o tamanho do texto
            (<em>A</em>, <em>A+</em> ou <em>A++</em>) para maior conforto visual.
        </li>
        <li>
            <strong>Espaçamento entre linhas:</strong> ajusta a densidade vertical do texto,
            com níveis progressivos.
        </li>
        <li>
            <strong>Espaçamento entre letras:</strong> melhora a legibilidade das palavras
            ao aumentar o espaço entre caracteres.
        </li>
        <li>
            <strong>Espaçamento entre palavras:</strong> facilita a separação visual entre termos,
            tornando a leitura mais confortável.
        </li>
    </ul>
    <p>
        Essas configurações afetam exclusivamente a visualização do manual. Ao acessar o sistema em outro navegador
        ou dispositivo, as configurações retornam ao padrão.
    </p>
</div>
<aside class="chapter-aside hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-semibold uppercase tracking-wider text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed text-gray-700 dark:text-gray-300 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-1.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-semibold">1.1</span>
            <span>Sobre o sistema</span>
        </a>
        <a href="#cap-1.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Objetivos Principais</span>
        </a>

        <a href="#cap-1.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-semibold">1.2</span>
            <span>Público-Alvo</span>
        </a>

        <a href="#cap-1.3" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-3 font-medium">
            <span class="font-semibold">1.3</span>
            <span>Sobre o SIMBAJU</span>
        </a>

        <a href="#cap-1.4" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 font-medium">
            <span class="font-semibold">1.4</span>
            <span>Sobre este Manual do Usuário</span>
        </a>
        <a href="#cap-1.4-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Finalidade do Manual</span>
        </a>
        <a href="#cap-1.4-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Conteúdo Abordado</span>
        </a>
        <a href="#cap-1.4-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Público e Objetivo de Uso</span>
        </a>

        <a href="#cap-1.4.1" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-semibold">1.4.1</span>
            <span>Navegação</span>
        </a>
        <a href="#cap-1.4.1-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Navegação do manual</span>
        </a>
        <a href="#cap-1.4.1-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Navegação do capítulo</span>
        </a>
        <a href="#cap-1.4.1-c" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Voltar ao topo</span>
        </a>

        <a href="#cap-1.4.2" class="sub-chapter-link grid grid-cols-[auto_1fr] gap-x-2 mb-1 !pl-7 font-medium">
            <span class="font-semibold">1.4.1</span>
            <span>Preferências de leitura</span>
        </a>
        <a href="#cap-1.4.2-a" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-1 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Restaurar configurações</span>
        </a>
        <a href="#cap-1.4.2-b" class="sub-chapter-link grid grid-cols-[auto_1fr] mb-3 !pl-10 text-gray-500 dark:text-gray-400">
            <span>Opções disponíveis</span>
        </a>
    </nav>
</aside>
