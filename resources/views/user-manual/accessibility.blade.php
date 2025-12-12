<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>
    <!-- Section 1: Accessibility Overview (Mantido como destaque, igual seu primeiro bloco de perfil) -->
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-3xl font-bold">10. Acessibilidade</h1>
    </article>

    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Modo Escuro</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            Reduz o cansaço visual em ambientes com pouca luz e melhora a experiência de uso à noite.
        </p>

        <ol class="list-decimal pl-6 space-y-2 text-gray-800">
            <li>
                <strong>Acesse Configurações:</strong> Vá para seu Perfil → Preferências
            </li>
            <li>
                <strong>Procure por Tema:</strong> Vá para seu Perfil → Preferências
            </li>
            <li>
                <strong>Escolha Uma Opção:</strong> Claro (padrão) | Escuro
            </li>
        </ol>
    </article>

    <!-- Section 2: Colorblind Filters -->
    <article class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-800">
        <h1 class="text-xl font-bold mb-4">Filtros para Daltonismo</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            O SIRUS oferece filtros especiais para usuários com deficiência de visão de cores.
            O daltonismo é uma condição visual que altera a forma como as cores são percebidas.
            Ele afeta cerca de 8% dos homens e 0,5% das mulheres. Para tornar a navegação mais confortável,
            oferecemos filtros de simulação que ajudam a ajustar a visualização conforme cada tipo de daltonismo.
        </p>
        {{--
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3 mb-6">
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-100">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Acromatopsia</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    É a forma mais rara e severa de daltonismo. Pessoas com acromatopsia veem apenas em escala
                    de cinza, sendo insensíveis a todas as cores. Uma condição extremamente desafiadora.
                </p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-100">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Deuteranopia</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Afeta a percepção da cor verde. Similar à protanopia, mas afeta principalmente
                    os receptores de cor verde, resultando em dificuldade similar com vermelho e verde.
                </p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-100">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Protanopia</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Afeta principalmente a percepção da cor vermelha. Pessoas com protanopia têm dificuldade
                    em distinguir entre vermelho e verde, muitas vezes vendo-os em tons de amarelo e azul.
                </p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg border border-gray-100">
                <h4 class="font-semibold text-gray-900 dark:text-white mb-2">Tritanopia</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    É o tipo mais raro de daltonismo, afetando a percepção das cores azul e amarelo.
                    Pessoas afetadas dificilmente conseguem distinguir entre azul e amarelo, verde e rosa.
                </p>
            </div>
        </div>--}}

        <ul class="list-disc pl-6 space-y-2 mb-4 text-gray-800">
            <li>
                <strong>Acromatopsia:</strong> É a forma mais rara e severa de daltonismo. Pessoas com acromatopsia veem apenas em escala
                de cinza, sendo insensíveis a todas as cores. Uma condição extremamente desafiadora.
            </li>
            <li>
                <strong>Deuteranopia:</strong> Afeta a percepção da cor verde. Similar à protanopia, mas afeta principalmente
                os receptores de cor verde, resultando em dificuldade similar com vermelho e verde.
            </li>
            <li>
                <strong>Protanopia:</strong> Afeta principalmente a percepção da cor vermelha. Pessoas com protanopia têm dificuldade
                em distinguir entre vermelho e verde, muitas vezes vendo-os em tons de amarelo e azul.
            </li>
            <li>
                <strong>Tritanopia:</strong> É o tipo mais raro de daltonismo, afetando a percepção das cores azul e amarelo.
                Pessoas afetadas dificilmente conseguem distinguir entre azul e amarelo, verde e rosa.
            </li>
        </ul>

        <h2 class="font-semibold mb-2">Como ativar:</h2>
        <ol class="list-decimal pl-6 space-y-2 text-gray-800">
            <li>
                Vá para Perfil → Acessibilidade
            </li>
            <li>
                Abra "Filtros de Daltonismo"
            </li>
            <li>
                Escolha o tipo que melhor se aplica
            </li>
            <li>
                As cores serão ajustadas automaticamente
            </li>
        </ol>
    </article>

    <!-- Section 3: Libras Assistant -->
    <article class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-800">
        <h1 class="text-xl font-bold mb-4">Assistente de Libras</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            Libras (Língua Brasileira de Sinais) é a língua natural da comunidade surda.
            Nosso sistema disponibiliza o VLibras, uma tecnologia desenvolvida pelo Ministério da Economia e pela UFPE,
            que traduz textos, elementos da interface e partes do conteúdo multimídia para Libras por meio de um avatar animado.
            Ele auxilia na compreensão de páginas, documentos e conteúdos digitais, ampliando significativamente a acessibilidade
            para pessoas surdas.
        </p>

        <h2 class="font-semibold mb-2">Como ativar:</h2>
        <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800">
            <li>
                <strong>Ativar Assistente:</strong> Clique no ícone no canto inferior direito
            </li>
            <li>
                <strong>Selecionar Conteúdo:</strong> O assistente interpreta o conteúdo da página
            </li>
            <li>
                <strong>Ativar Legendas:</strong> As legendas aparecem automaticamente
            </li>
            <li>
                <strong>Ajustar Velocidade:</strong> Controle a velocidade conforme necessário
            </li>
        </ol>

        <h2 class="font-semibold mb-2">Visibilidade:</h2>
        <p class="leading-relaxed text-gray-800">
            O ícone do assistente aparece em todas as páginas, no lado direito da tela, próximo ao ícone de daltonismo.
            Você pode ocultá-lo a qualquer momento acessando Perfil → Acessibilidade.
            Essa preferência é salva apenas no navegador atual. Se você ocultar o ícone e depois acessar o sistema em outro navegador, ele voltará a aparecer.
        </p>
    </article>

    <!-- Section 4: Additional Accessibility Features -->
    <article class="bg-white dark:bg-gray-900 rounded-lg p-6 shadow-sm border border-gray-200 dark:border-gray-800">
        <h1 class="text-xl font-bold mb-4">Outros Recursos de Acessibilidade</h1>

        <div class="grid md:grid-cols-2 gap-4">
            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Zoom de Texto</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Aumente ou diminua usando Ctrl + (+/-)</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Navegação por Teclado</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Use Tab e Enter para navegar</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Design Responsivo</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Interface adaptável a qualquer dispositivo</p>
            </div>

            <div class="bg-gray-50 dark:bg-gray-800 p-4 rounded-lg">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Linguagem Clara</h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">Textos simples e diretos</p>
            </div>
        </div>
    </article>
</x-documentation-layout>
