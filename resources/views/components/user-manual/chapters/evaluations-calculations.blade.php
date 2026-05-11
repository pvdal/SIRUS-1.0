<div class="min-w-0 max-w-4xl w-full xl:pe-24" :class="{ {{ $textSettings }} }">
    <style>
        /* Responsividade das equações */
        .math-block {
            overflow-x: auto;
            max-width: 100%;
            padding: 0.5rem;
        }
    </style>
    {{-- Capítulo 8 --}}
    <h1 class="text-3xl font-bold mb-14 text-gray-900 dark:text-gray-100">8. Cálculos das avaliações</h1>

    {{-- Capítulo 8.1 --}}
    <h2 id="cap-8.1" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">8.1 Considerações iniciais</h2>

    <h3 id="cap-8.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Glossário de termos</h3>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li><code class="font-bold break-words hyphens-auto">Average</code> = Média</li>
        <li><code class="font-bold break-words hyphens-auto">Score</code> = Nota ponderada</li>
        <li><code class="font-bold break-words hyphens-auto">GroupScore</code> = Nota final do grupo</li>
        <li><code class="font-bold break-words hyphens-auto">IndividualScore</code> = Nota individual do estudante</li>
        <li><code class="font-bold break-words hyphens-auto">AverageIndividualScore</code> = Média das notas individuais</li>
        <li><code class="font-bold break-words hyphens-auto">FinalScore</code> = Nota final</li>
    </ul>

    <h3 id="cap-8.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Níveis de desempenho</h3>
    <ul class="list-disc pl-6 mb-10 space-y-1">
        <li><strong>Insatisfatório</strong> → 2 pontos</li>
        <li><strong>Regular</strong> → 6 pontos</li>
        <li><strong>Bom</strong> → 8 pontos</li>
        <li><strong>Excelente</strong> → 10 pontos</li>
    </ul>

    {{-- Capítulo 8.2 --}}
    <h2 id="cap-8.2" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">8.2 Rubrica de avaliação em grupo</h2>

    <h3 id="cap-8.2-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Definição do conjunto de eixos de grupo</h3>
    <p class="mb-2">
        <strong>Grupo</strong> é definido como:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            Grupo =
            \{
                a \in Axes \mid type(a) = "in\ group"
            \}
        \]
    </p>
    <p class="mb-4">
        Ou seja, <strong>Grupo</strong> é o conjunto de todos os eixos
        \(a\) pertencentes ao conjunto geral de eixos (<em>Axes</em>)
        cujo atributo <code class="font-bold">type</code> é igual a
        <code class="font-bold">"in group"</code>.
    </p>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.2-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">1. Cálculo do score de cada eixo</h3>
    <p class="mb-2">
        Para cada eixo \(a \in Grupo\):
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>\(n_a\): número de critérios do eixo \(a\)</li>
        <li>\(g_c\): nota atribuída ao critério \(c\)</li>
        <li>\(w_a\): peso do eixo \(a\) (em %)</li>
    </ul>
    <p class="mb-2">
        A média dos critérios do eixo é:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            Average_a =
            \frac{
                \sum_{c=1}^{n_a} g_c
            }{ n_a }
        \]
    </p>
    <p class="mb-2">
        O score ponderado do eixo é:
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            Score_a =
            Average_a \cdot \frac{w_a}{100}
        \]
    </p>

    <h3 id="cap-8.2-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">2. Nota final do grupo</h3>
    <p class="mb-2">
        Somando todos os scores dos eixos de grupo:
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            GroupScore =
            \sum_{a \in Grupo} Score_a
        \]
    </p>

    <h3 id="cap-8.2-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Expressão geral</h3>
    <p class="mb-8 math-block scrollbar-custom">
        \[
            GroupScore =
            \sum_{a \in Grupo} \left(
                \frac{
                    \sum_{c=1}^{n_a} g_c
                }{ n_a }
                \cdot
                \frac{w_a}{100}
            \right)
        \]
    </p>

    {{-- Capítulo 8.2.1 --}}
    <h2 id="cap-8.2.1" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">8.2.1 Interpretação passo a passo</h2>
    <p class="mb-2">
        Considere uma rubrica de grupo com:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>2 eixos de avaliação</li>
        <li>2 critérios em cada eixo</li>
        <li>peso de 50% para cada eixo</li>
    </ul>
    <details class=" mb-4 rounded-lg border border-gray-200 dark:border-gray-700">
        <summary
            class="cursor-pointer select-none px-4 py-3 font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-800"
        >
            Visualizar exemplo de rubrica de grupo
        </summary>

        <div class="overflow-x-auto scrollbar-custom p-4">
            <img
                src="{{ asset('/img/group_rubric.png') }}"
                alt="Exemplo de rubrica"
                class="w-auto max-w-none h-auto rounded-lg"
            >
        </div>
    </details>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.2.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">1. Eixo 1</h3>
    <p class="mb-2">
        Notas atribuídas aos critérios:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Critério 1: 8</li>
        <li>Critério 2: 10</li>
    </ul>
    <p class="mb-2">
        A média do eixo é calculada por:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            Average_1 =
            \frac{8 + 10}{2}
            = 9
        \]
    </p>
    <p class="mb-2">
        Aplicando o peso do eixo (50%):
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            Score_1 =
            9 \cdot \frac{50}{100}
            = 4.5
        \]
    </p>

    <h3 id="cap-8.2.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">2. Eixo 2</h3>
    <p class="mb-2">
        Notas atribuídas aos critérios:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Critério 1: 6</li>
        <li>Critério 2: 8</li>
    </ul>
    <p class="mb-2">
        A média do eixo é calculada por:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            Average_2 =
            \frac{6 + 8}{2}
            = 7
        \]
    </p>
    <p class="mb-2">
        Aplicando o peso do eixo (50%):
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            Score_2 =
            7 \cdot \frac{50}{100}
            = 3.5
        \]
    </p>

    <h3 id="cap-8.2.-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">3. Nota final do grupo</h3>
    <p>
        A nota final do grupo é a soma dos scores dos eixos:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            GroupScore =
            Score_1 + Score_2
        \]
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            GroupScore =
            4.5 + 3.5 =
            8
        \]
    </p>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.2.1-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Resumo do cálculo</h3>
    <ol class="list-decimal pl-6 mb-10 space-y-1">
        <li>
            Calcula-se a média das notas dos critérios de cada eixo.
        </li>
        <li>
            A média do eixo é multiplicada pelo peso do eixo.
        </li>
        <li>
            Soma-se o score de todos os eixos.
        </li>
        <li>
            O resultado corresponde à nota final da rubrica de grupo.
        </li>
    </ol>

    {{-- Capítulo 8.3 --}}
    <h2 id="cap-8.3" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">8.3 Rubrica de avaliação individual</h2>

    <h3 id="cap-8.3-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Definição do conjunto de eixos individuais</h3>
    <p class="mb-2">
        <strong>Individual</strong> é definido como:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            Individual =
            \{
                a \in Axes \mid type(a) = "individual"
            \}
        \]
    </p>
    <p class="mb-2">
        Ou seja, <strong>Individual</strong> é o conjunto de todos os eixos
        \(a\) pertencentes ao conjunto geral de eixos (<em>Axes</em>)
        cujo atributo \(type\) é igual a
        \("individual"\).
    </p>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.3-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">1. Cálculo do score de cada eixo</h3>
    <p class="mb-2">
        Para cada eixo \(a \in Individual\):
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>\(s\): Estudante avaliado</li>
        <li>\(n_a\): número de critérios do eixo \(a\)</li>
        <li>\(g_{s,c}\): nota que o estudante \(s\) recebeu no critério \(c\)</li>
        <li>\(w_a\): peso do eixo \(a\) (em %)</li>
    </ul>
    <p class="mb-2">
        O score ponderado do eixo é:
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            Score_a =
            \frac{
                \sum_{c=1}^{n_a} g_{s,c}
            }{ n_a }
            \cdot
            \frac{w_a}{100}
        \]
    </p>

    <h3 id="cap-8.3-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">2. Nota final do aluno</h3>
    <p class="mb-2">
        Somando todos os scores dos eixos individuais:
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            IndividualScore_{ s } =
            \sum_{a \in Individual} Score_a
        \]
    </p>

    <h3 id="cap-8.3-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Expressão geral</h3>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            IndividualScore_{ s } =
            \sum_{a \in Individual} \left(
                \frac{
                    \sum_{c=1}^{n_a} g_{s,c}
                }{ n_a }
                \cdot \frac{w_a}{100}
            \right)
        \]
    </p>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.3-e" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Resumo do cálculo</h3>
    <ol class="list-decimal pl-6 mb-4 space-y-1">
        <li>
            Para cada eixo individual, soma-se as notas dos critérios do estudante.
        </li>
        <li>
            Divide-se pelo número de critérios → obtém-se a média do eixo.
        </li>
        <li>
            Multiplica-se essa média pelo peso do eixo (normalizado em fração).
        </li>
        <li>
            Soma-se o resultado de todos os eixos → obtém-se a <strong>nota individual do estudante</strong>.
        </li>
    </ol>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.3-f" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">3. Média individual</h3>
    <p class="mb-2">
        A equação é:
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            AverageIndividualScore = \frac{
                \sum_{s=1}^{N} IndividualScore_{ s }
            }{ N }
        \]
    </p>

    <h3 id="cap-8.3-g" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Expressão geral</h3>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            AverageIndividualScore = \frac{
            \sum_{s=1}^{N} \left(
                \sum_{a \in Individual} \left(
                    \frac{
                        \sum_{c=1}^{n_a} g_{s,c}
                    }{ n_a }
                    \cdot \frac{w_a}{100}
                \right)
            \right)
            }{ N }
        \]
    </p>

    <h3 id="cap-8.3-h" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Explicação</h3>
    <ol class="list-disc pl-6 mb-4 space-y-1">
        <li>
            \( N \) = número total de estudantes.
        </li>
        <li>
            \(IndividualScore_s\) nota individual de cada estudante.
        </li>
    </ol>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.3-i" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Resumo do cálculo</h3>
    <ol class="list-decimal pl-6 mb-8 space-y-1">
        <li>
            Soma-se todas as notas individuais dos estudantes.
        </li>
        <li>
            Divide-se pelo número total de estudantes.
        </li>
        <li>
            O resultado é a média individual da turma.
        </li>
    </ol>

    {{-- Capítulo 8.3.1 --}}
    <h2 id="cap-8.3.1" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">8.3.1 Interpretação passo a passo</h2>

    <p class="mb-2">
        Considere uma rubrica individual com:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>3 alunos avaliados</li>
        <li>2 eixos de avaliação</li>
        <li>2 critérios em cada eixo</li>
        <li>peso de 50% para cada eixo</li>
    </ul>
    <details class="mb-4 rounded-lg border border-gray-200 dark:border-gray-700">
        <summary
            class="cursor-pointer select-none px-4 py-3 font-medium text-gray-700 dark:text-gray-200 bg-gray-50 dark:bg-gray-800"
        >
            Visualizar exemplo de rubrica individual
        </summary>

        <div class="overflow-x-auto scrollbar-custom p-4">
            <img
                src="{{ asset('/img/individual_rubric.png') }}"
                alt="Exemplo de rubrica"
                class="w-auto max-w-none h-auto rounded-lg"
            >
        </div>
    </details>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.3.1-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">1. Eixo 1</h3>
    <p class="mb-2">
        Notas atribuídas aos critérios:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Critério 1: 10</li>
        <li>Critério 2: 8</li>
    </ul>
    <p class="mb-2">
        O score de cada aluno nesse eixo é:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            Score_1 =
            \frac{10 + 8}{2}
            \cdot
            \frac{50}{100} = 4.5
        \]
    </p>

    <h3 id="cap-8.3.1-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">2. Eixo 2</h3>
    <p class="mb-2">
        Notas atribuídas aos critérios:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Critério 1: 10</li>
        <li>Critério 2: 8</li>
    </ul>
    <p class="mb-2">
        O score de cada aluno nesse eixo é:
    </p>
    <p class="mb-4 math-block scrollbar-custom">
        \[
            Score_2 =
            \frac{10 + 8}{2}
            \cdot
            \frac{50}{100} = 4.5
        \]
    </p>

    <h3 id="cap-8.3.1-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">3. Notas finais dos alunos</h3>
    <p class="mb-2">
        A nota final dos alunos é a soma dos scores dos eixos:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            \begin{aligned}
                IndividualScore_1 &= IndividualScore_2 \\
                &= IndividualScore_3 \\
                &= Score_1 + Score_2
            \end{aligned}
        \]
    </p>
    <p class="mb-4 overflow-x-auto">
        \[
            \begin{aligned}
                IndividualScore_1 &= IndividualScore_2 \\
                &= IndividualScore_3 \\
                &= 4.5 + 4.5 \\
                &= 9
            \end{aligned}
        \]
    </p>

    <h3 id="cap-8.3.1-d" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">4. Média individual</h3>
    <p class="mb-2">
        A nota média individual dos alunos é:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            AverageIndividualScore = \frac{
                IndividualScore_1 + IndividualScore_2 + IndividualScore_3
            }{ 3 }
        \]
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            AverageIndividualScore = \frac{
            9 + 9 + 9
            }{ 3 }
            =
            9
        \]
    </p>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.3.1-e" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">
        Resumo do cálculo
    </h3>
    <ol class="list-decimal pl-6 mb-10 space-y-1">
        <li>
            Para cada eixo individual, calcula-se a média das notas dos critérios do aluno.
        </li>
        <li>
            Multiplica-se essa média pelo peso do eixo.
        </li>
        <li>
            Soma-se o resultado de todos os eixos → obtém-se a nota individual de cada aluno.
        </li>
        <li>
            Repete-se o processo para todos os alunos.
        </li>
        <li>
            Soma-se todas as notas individuais e divide-se pelo número de alunos → obtém-se a média individual da turma.
        </li>
    </ol>

    {{-- Capítulo 8.4 --}}
    <h2 id="cap-8.4" class="text-2xl font-semibold mb-4 text-gray-900 dark:text-gray-100">8.4 Resultado final</h2>
    <p class="mb-2">
       Cada rubrica tem um peso definido:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>\(w_g\): peso da parte do grupo (em %)</li>
        <li>\(w_i\): peso da parte individual (em %)</li>
    </ul>

    <h3 id="cap-8.4-a" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Expressão geral</h3>
    <p class="mb-4 math-block scrollbar-custom scrollbar-custom">
        \[
            FinalScore =
            \frac{
                GroupScore \cdot w_g
            }{ 100 }
            +
            \frac{
                AverageIndividualScore \cdot w_i
            }{ 100 }
        \]
    </p>
    {{--
    <p class="mb-4 math-block scrollbar-custom scrollbar-custom">
        \[
            FinalScore =
            \frac{
            \left(
                \sum_{a \in Grupo} \left(
                \frac{
                \sum_{c=1}^{n_a} g_c
                }{
                n_a
                }
                \cdot \frac{w_a}{100}
                \right)
            \right)
            \cdot w_g
            }{ 100 }
            +
            \frac{
            \left(
                \frac{
                \sum_{s=1}^{N} \left(
                \sum_{a \in Individual} \left(
                \frac{
                \sum_{c=1}^{n_a} g_{s,c}
                }{ n_a }
                \cdot \frac{w_a}{100}
                \right)
                \right)
                }{ N }
            \right)
            \cdot w_i
            }{ 100 }
        \]
    </p>
    --}}
    <h3 id="cap-8.4-b" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Interpretação passo a passo</h3>
    <p class="mb-2">
        Considere os seguintes pesos atribuídos:
    </p>
    <ul class="list-disc pl-6 mb-4 space-y-1">
        <li>Rubrica de avaliação em grupo: 60%</li>
        <li>Rubrica de avaliação individual: 40%</li>
    </ul>
    <p class="mb-2">
        A nota final de cada rubrica de grupo é:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            GroupScore = 8
        \]
    </p>
    <p class="mb-2">
        A nota final de cada rubrica individual é:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            AverageIndividualScore = 9
        \]
    </p>
    <p class="mb-2">
        Nota final:
    </p>
    <p class="mb-2 math-block scrollbar-custom">
        \[
            FinalScore =
            \frac{
                8 \cdot 60
            }{ 100 }
            +
            \frac{
                9 \cdot 40
            }{ 100 }
            =
        8.4
        \]
    </p>
    <hr class="mb-4 border-t border-gray-200 dark:border-gray-800">

    <h3 id="cap-8.4-c" class="font-semibold mb-2 text-gray-900 dark:text-gray-100">Resumo do cálculo</h3>
    <ol class="list-decimal pl-6 space-y-1">
        <li>
            Para cada eixo de grupo: calcula-se a média dos critérios e aplica-se o peso → obtém-se o <code class="font-bold break-words hyphens-auto">GroupScore</code>.
        </li>
        <li>
            Para cada eixo individual: calcula-se a média dos critérios do aluno e aplica-se o peso → obtém-se o <code class="font-bold break-words hyphens-auto">IndividualScore</code>.
        </li>
        <li>
            Soma-se as notas individuais e divide-se pelo número de alunos → obtém-se o <code class="font-bold break-words hyphens-auto">AverageIndividualScore</code>.
        </li>
        <li>
            Combina-se <code class="font-bold break-words hyphens-auto">GroupScore</code> e <code class="font-bold break-words hyphens-auto">AverageIndividualScore</code> aplicando os pesos <strong>\(w_g\)</strong> e <strong>\(w_i\)</strong>.
        </li>
        <li>
            O resultado é a <code class="font-bold break-words hyphens-auto">FinalScore</code> do grupo.
        </li>
    </ol>
</div>
<aside class="chapter-aside flex-1 hidden xl:block text-sm min-w-60 border-l border-gray-300 dark:border-gray-700" :class="{ 'sticky-chapter-aside': stickyNav, 'hidden-chapter-aside': !showChapterNav }">
    <h2 class="font-bold uppercase tracking-wider [word-spacing:0] text-gray-700 dark:text-gray-300 mb-4">
        Neste capítulo
    </h2>
    <nav class="leading-relaxed tracking-normal [word-spacing:0] text-gray-500 dark:text-gray-400 overflow-y-auto max-h-[calc(100vh-86px-2.5rem)] scrollbar-custom">
        <a href="#cap-8.1" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            8.1 Considerações iniciais
        </a>
        <a href="#cap-8.1-a" class="sub-chapter-link block mb-1 !pl-10">
            Glossário de termos
        </a>
        <a href="#cap-8.1-b" class="sub-chapter-link block mb-3 !pl-10">
            Níveis de desempenho
        </a>

        <a href="#cap-8.2" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            8.2 Rubrica de avaliação em grupo
        </a>
        <a href="#cap-8.2-a" class="sub-chapter-link block mb-1 !pl-10">
            Definição do conjunto de eixos
        </a>
        <a href="#cap-8.2-b" class="sub-chapter-link block mb-1 !pl-10">
            1. Cálculo do score de cada eixo
        </a>
        <a href="#cap-8.2-c" class="sub-chapter-link block mb-1 !pl-10">
            2. Nota final do grupo
        </a>
        <a href="#cap-8.2-d" class="sub-chapter-link block mb-3 !pl-10">
            Expressão geral
        </a>

        <a href="#cap-8.2.1" class="sub-chapter-link block mb-1 !pl-7 font-semibold text-gray-700 dark:text-gray-300">
            8.2.1 Interpretação passo a passo
        </a>
        <a href="#cap-8.2.1-a" class="sub-chapter-link block mb-1 !pl-10">
            1. Eixo 1
        </a>
        <a href="#cap-8.2.1-b" class="sub-chapter-link block mb-1 !pl-10">
            2. Eixo 2
        </a>
        <a href="#cap-8.2.-c" class="sub-chapter-link block mb-1 !pl-10">
            3. Nota final do grupo
        </a>
        <a href="#cap-8.2.1-d" class="sub-chapter-link block mb-3 !pl-10">
            Resumo do cálculo
        </a>

        <a href="#cap-8.3" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            8.3 Rubrica de avaliação individual
        </a>
        <a href="#cap-8.3-a" class="sub-chapter-link block mb-1 !pl-10">
            Definição do conjunto de eixos
        </a>
        <a href="#cap-8.3-b" class="sub-chapter-link block mb-1 !pl-10">
            1. Cálculo do score de cada eixo
        </a>
        <a href="#cap-8.3-c" class="sub-chapter-link block mb-1 !pl-10">
            2. Nota final do aluno
        </a>
        <a href="#cap-8.3-d" class="sub-chapter-link block mb-1 !pl-10">
            Expressão geral
        </a>
        <a href="#cap-8.3-e" class="sub-chapter-link block mb-1 !pl-10">
            Resumo do cálculo
        </a>
        <a href="#cap-8.3-f" class="sub-chapter-link block mb-1 !pl-10">
            3. Média individual
        </a>
        <a href="#cap-8.3-g" class="sub-chapter-link block mb-1 !pl-10">
            Expressão geral
        </a>
        <a href="#cap-8.3-h" class="sub-chapter-link block mb-1 !pl-10">
            Explicação
        </a>
        <a href="#cap-8.3-i" class="sub-chapter-link block mb-3 !pl-10">
            Resumo do cálculo
        </a>

        <a href="#cap-8.3.1" class="sub-chapter-link block mb-1 !pl-7 font-semibold text-gray-700 dark:text-gray-300">
            8.3.1 Interpretação passo a passo
        </a>
        <a href="#cap-8.3.1-a" class="sub-chapter-link block mb-1 !pl-10">
            1. Eixo 1
        </a>
        <a href="#cap-8.3.1-b" class="sub-chapter-link block mb-1 !pl-10">
            2. Eixo 2
        </a>
        <a href="#cap-8.3.1-c" class="sub-chapter-link block mb-1 !pl-10">
            3. Notas finais dos alunos
        </a>
        <a href="#cap-8.3.1-d" class="sub-chapter-link block mb-1 !pl-10">
            4. Média individual
        </a>
        <a href="#cap-8.3.1-e" class="sub-chapter-link block mb-3 !pl-10">
            Resumo do cálculo
        </a>

        <a href="#cap-8.4" class="sub-chapter-link block mb-1 font-semibold text-gray-700 dark:text-gray-300">
            8.4 Resultado final
        </a>
        <a href="#cap-8.4-a" class="sub-chapter-link block mb-1 !pl-10">
            Expressão geral
        </a>
        <a href="#cap-8.4-b" class="sub-chapter-link block mb-1 !pl-10">
            Interpretação passo a passo
        </a>
        <a href="#cap-8.4-c" class="sub-chapter-link block mb-3 !pl-10">
            Resumo do cálculo
        </a>
    </nav>
</aside>

@push('scripts')
    {{-- Evita o menu do mathjax --}}
    <script>
        window.MathJax = {
            options: {
                enableMenu: false
            },
            tex: {
                inlineMath: [['$', '$'], ['\\(', '\\)']]
            }
        };
    </script>

    <script
        id="MathJax-script"
        async
        src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js">
    </script>
@endpush
