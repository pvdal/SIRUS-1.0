<div class="min-w-0 max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    {{-- Capítulo 11 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">11. Acessibilidade</h1>

    {{-- Capítulo 11.1 --}}
    <h2 id="cap-11.1" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.1 Tema escuro</h2>
    <p class="mb-2">
        O tema escuro reduz o cansaço visual em ambientes com pouca iluminação e melhora o conforto
        durante o uso prolongado do sistema. Embora não seja classificado como um recurso direto de
        acessibilidade, ele contribui significativamente para a ergonomia visual.
    </p>
    <p class="mb-10">
        A alternância entre tema claro e escuro é feita pelo cabeçalho da aplicação, conforme
        descrito no <strong>capítulo 2.5</strong>.
    </p>

    {{-- Capítulo 11.2 --}}
    <h2 id="cap-11.2" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.2 Filtros para daltonismo</h2>
    <p class="mb-4">
        O SIRUS oferece filtros especiais para usuários com deficiência de visão de cores.
        O daltonismo é uma condição visual que altera a forma como as cores são percebidas.
        Ele afeta cerca de 8% dos homens e 0,5% das mulheres. Para tornar a navegação mais confortável,
        oferecemos filtros de simulação que ajudam a ajustar a visualização conforme cada tipo de daltonismo.
    </p>

    <h3 id="cap-11.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Filtros disponíveis</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Padrão:</strong> Visualização sem alterações</li>
        <li><strong>Acromatomalia:</strong> Redução geral da intensidade das cores</li>
        <li><strong>Acromatopsia:</strong> Visualização em escala de cinza</li>
        <li><strong>Deuteranomalia:</strong> Sensibilidade reduzida ao verde</li>
        <li><strong>Deuteranopia:</strong> Dificuldade severa na distinção entre verde e vermelho</li>
        <li><strong>Protanomalia:</strong> Sensibilidade reduzida ao vermelho</li>
        <li><strong>Protanopia:</strong> Dificuldade acentuada na percepção do vermelho</li>
        <li><strong>Tritanomalia:</strong> Sensibilidade reduzida ao azul e amarelo</li>
        <li><strong>Tritanopia:</strong> Dificuldade severa na distinção entre azul e amarelo</li>
    </ul>

    <h3 id="cap-11.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Ativação pelo perfil</h3>
    <ol class="list-decimal pl-6 space-y-1 mb-4">
        <li>
            Na página de perfil — acessível pelo menu superior, conforme exposto no capítulo 2.5 deste manual —,
            localize a seção <strong>"Acessibilidade"</strong>
        </li>
        <li>Selecione o filtro de daltonismo desejado</li>
        <li>Opcionalmente, ative a opção <strong>"Exibir ícone de daltonismo"</strong></li>
    </ol>

    <h3 id="cap-11.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Ícone flutuante de daltonismo</h3>
    <p class="mb-2">
        Ao ativar a exibição do ícone de daltonismo, um botão flutuante é apresentado na interface,
        permitindo acesso rápido às configurações sem a necessidade de retornar ao perfil. Esse botão
        é identificado por um ícone de olho, e ao ser clicado exibe duas opções:
    </p>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li><strong>Seleção de filtro:</strong> Abre um menu com um seletor de filtros de daltonismo.</li>
        <li><strong>Posicionamento:</strong> Permite definir a posição do ícone na tela.</li>
    </ul>
    <p class="mb-10">
        As posições disponíveis são seis: esquerda ou direita da tela, podendo ser posicionadas
        no topo, no centro ou na parte inferior. O ícone pode ser exibido ou ocultado a qualquer momento
        pelas opções correspondentes no menu de acessibilidade.
    </p>

    {{-- Capítulo 11.3 --}}
    <h2 id="cap-11.3" class="text-2xl font-semibold mb-2 text-gray-900 dark:text-gray-100">11.3 Assistente de Libras (VLibras)</h2>
    <p class="mb-4">
        Libras (Língua Brasileira de Sinais) é a língua natural da comunidade surda. Nosso sistema
        disponibiliza o VLibras, uma tecnologia desenvolvida pelo Ministério da Economia e pela
        Universidade Federal de Pernambuco (UFPE), que traduz textos, elementos da interface e
        partes do conteúdo multimídia para Libras por meio de um avatar animado. Ele auxilia na
        compreensão de páginas, documentos e conteúdos digitais, ampliando significativamente a
        acessibilidade para pessoas surdas.
    </p>

    <h3 id="cap-11.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Acesso e visibilidade</h3>
    <ul class="list-disc pl-6 space-y-1 mb-4">
        <li>O acesso ao VLibras é feito exclusivamente por meio do ícone flutuante</li>
        <li>O ícone pode ser exibido ou ocultado na seção de Acessiblidade do perfil</li>
        <li>Sem o ícone visível, o assistente não pode ser utilizado</li>
    </ul>

    <h3 id="cap-11.3-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Utilização</h3>
    <ol class="list-decimal pl-6 space-y-1 mb-4">
        <li>
            Ative o assistente clicando no ícone VLibras exibido na tela
        </li>
        <li>
            Ao selecionar um conteúdo, o assistente interpreta o conteúdo da página
        </li>
        <li>
            Ao ativar as legendas elas são exibidas automaticamente
        </li>
        <li>
            Controle a velocidade conforme necessário
        </li>
    </ol>
    <p>
        As preferências de exibição do VLibras e do ícone de daltonismo são armazenadas apenas no
        navegador em uso. Ao acessar o sistema em outro navegador ou dispositivo, as configurações
        retornam ao padrão.
    </p>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-11.1" class="sub-chapter-link block mb-3 font-semibold text-gray-700 dark:text-gray-300">
            11.1 Tema escuro
        </a>

        <a href="#cap-11.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            11.2 Filtros para daltonismo
        </a>
        <a href="#cap-11.2-a" class="sub-chapter-link block mb-1 !pl-10">
            Filtros disponíveis
        </a>
        <a href="#cap-11.2-b" class="sub-chapter-link block mb-1 !pl-10">
            Ativação pelo perfil
        </a>
        <a href="#cap-11.2-c" class="sub-chapter-link block mb-3 !pl-10">
            Ícone flutuante de daltonismo
        </a>

        <a href="#cap-11.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            11.3 Assistente de Libras (VLibras)
        </a>
        <a href="#cap-11.3-a" class="sub-chapter-link block mb-1 !pl-10">
            Acesso e visibilidade
        </a>
        <a href="#cap-11.3-b" class="sub-chapter-link block mb-3 !pl-10">
            Utilização
        </a>
    </nav>
</aside>
