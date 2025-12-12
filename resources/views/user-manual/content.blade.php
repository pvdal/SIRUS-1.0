<x-documentation-layout>
    <x-slot name="options">
        <x-manual-pages/>
    </x-slot>

    {{-- Seção 1 --}}
    <article id="introduction" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">1. Introdução</h1>

        <h2 class="text-xl font-semibold mb-4">Sobre o Sistema</h2>
        <p class="leading-relaxed mb-4">
            O <strong>SIRUS</strong> é uma plataforma intuitiva para gerenciar, aplicar e analisar
            avaliações acadêmicas com eficiência e padronização. O sistema foi desenvolvido para
            facilitar o processo de avaliação de alunos, organizando cronogramas, cadastros e
            critérios de desempenho.
        </p>
        <h3 class="font-semibold mb-2">Objetivos Principais:</h3>
        <ul class="list-disc pl-6 space-y-1 mb-8 text-gray-800">
            <li>Centralizar o gerenciamento de avaliações acadêmicas</li>
            <li>Padronizar critérios e rubricas de avaliação</li>
            <li>Facilitar o agendamento de bancas avaliativas</li>
            <li>Organizar dados de alunos, professores e coordenadores</li>
            <li>Gerar análises e relatórios de desempenho</li>
        </ul>

        <h2 class="text-xl font-semibold mb-4">Público-Alvo</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            O sistema foi projetado para os seguintes usuários:
        </p>
        <div class="space-y-1 text-gray-800">
            <p><strong>Coordenadores acadêmicos:</strong> Gerenciam toda a plataforma</p>
            <p><strong>Professores e avaliadores:</strong> Realizam avaliações de alunos</p>
            <p><strong>Alunos e grupos:</strong> Participam de avaliações e acompanham resultados</p>
        </div>
    </article>

    {{-- Seção 2 --}}
    <article id="access" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">2. Acesso ao Sistema</h1>

        <h2 class="text-xl font-semibold mb-4">Tela de Boas-vindas</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Ao acessar o SIRUS pela primeira vez, você verá a tela inicial que apresenta:
        </p>
        <ul class="list-disc pl-6 space-y-1 text-gray-800">
            <li>Menu de navegação, que permite navegar dentro da própria página, acessar o <strong>manual de usuário</strong>, <strong>termos</strong> e <strong>políticas</strong> do sistema, ou <strong>fazer login</strong></li>
            <li>Nome do sistema: <strong>SIRUS - Sistema de Rubricas para Gestão Avaliativa do SIMBAJU</strong></li>
            <li>Descrição da plataforma</li>
            <li>Botões: <strong>Fazer Login</strong> e <strong>Manual do Usuário</strong></li>
            <li>Descrição das principais funcionalidades que o sistema oferece</li>
            <li>Breve descrição sobre o <strong>SIMBAJU</strong></li>
        </ul>
        <p class="leading-relaxed mt-2 mb-8 text-gray-800">
            Clique em "<strong>Fazer Login</strong>" para acessar a autenticação do sistema.
        </p>

        <h2 class="text-xl font-semibold mb-4">Autenticação de Usuário</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Na tela de login, você deverá:
        </p>
        <ol class="list-decimal pl-6 space-y-1 text-gray-800">
            <li>Inserir seu <strong>E-mail</strong> - Seu endereço de e-mail cadastrado no sistema</li>
            <li>Inserir sua <strong>Senha</strong> - Sua senha de acesso</li>
            <li>Clicar em <strong>"Entrar"</strong> - Para validar suas credenciais</li>
        </ol>
        <p class="leading-relaxed mt-2 text-gray-800">
            O usuário pode escolher manter sua senha oculta enquanto digita ou visualizá-la <br>
            Ao clicar em <strong>"Manter conectado"</strong>, não será mais necessário fazer login naquele navegador até uma limpeza de cache.
        </p>
        <div class="mt-6 mb-8 bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            <p class="font-semibold">
                Dica de segurança
            </p>
            <p class="text-sm leading-relaxed">
                Nunca compartilhe sua senha com outras pessoas. Se esqueceu sua senha, contate o administrador do sistema.
            </p>
        </div>

        <h2 class="text-xl font-semibold mb-4">Primeiro Acesso – Validação de E-mail</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            No primeiro acesso ao SIRUS, será necessário validar seu e-mail. Siga os passos:
        </p>
        <ol class="list-decimal pl-6 space-y-1 text-gray-800">
            <li>Receber sua <strong>senha temporária</strong> enviada pelo sistema após cadastro <do></do> coordenador</li>
            <li>Fazer login usando a senha temporária</li>
            <li>Solicitar o envio do <strong>e-mail de validação</strong></li>
            <li>Acessar o link enviado para confirmar seu endereço de e-mail</li>
            <li>Aceitar os <strong>termos de uso</strong> e <strong>políticas do sistema</strong></li>
            <li>Acessar o SIRUS com acesso completo</li>
        </ol>
        <p class="leading-relaxed mt-2 text-gray-800">
            O link de validação expira em 24 horas. Caso expire, é possível solicitar um novo na página de login.
        </p>
    </article>

    {{-- Seção 3 --}}
    <article id="security" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">3. Segurança</h1>

        <h1 class="text-xl font-bold mb-4">Recuperação de Senha</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            Se você esqueceu sua senha, siga este processo para recuperá-la:
        </p>
        <ol class="list-decimal pl-6 space-y-2 text-gray-800">
            <li>
                <strong>Acesse a Página de Login:</strong> Clique em <strong>"Esqueci minha senha"</strong> na tela de login.
            </li>
            <li>
                <strong>Insira seu E-mail:</strong> Digite o e-mail cadastrado no sistema.
            </li>
            <li>
                <strong>Receba o E-mail de Recuperação:</strong> Verifique sua caixa de entrada (e pasta de spam) por um e-mail de recuperação.
            </li>
            <li>
                <strong>Clique no Link:</strong> Abra o e-mail e clique no link de recuperação de senha.
            </li>
            <li>
                <strong>Defina Uma Nova Senha:</strong> Será redirecionado para uma página onde poderá inserir uma nova senha.
            </li>
            <li>
                <strong>Confirme a Nova Senha:</strong> Repita a senha para confirmar e clique em <strong>"Redefinir Senha"</strong>.
            </li>
            <li>
                <strong>Faça Login com Nova Senha:</strong> Retorne à página de login e acesse o sistema com sua nova senha.
            </li>
        </ol>
        <div class="mt-6 mb-8 bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            <p class="font-semibold">
                Atenção
            </p>
            <p class="text-sm leading-relaxed">
                O link de recuperação de senha expira em 1 hora. Se expirar, será necessário solicitar novamente.
                Sua nova senha deve ter no mínimo 8 caracteres, incluindo letras maiúsculas, minúsculas, números e caracteres especiais.
            </p>
        </div>

        <h1 class="text-xl font-bold mb-4">Autenticação de Dois Fatores (2FA)</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            A autenticação de dois fatores fornece segurança adicional à sua conta. Ao ativar, você precisará de um código além da sua senha para acessar o sistema.
        </p>
        <h2 class="font-semibold mb-2">Benefícios:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Proteção contra roubo de senha</li>
            <li>Acesso seguro mesmo se dados forem vazados</li>
            <li>Rastreamento de atividades suspeitas</li>
        </ul>
        <h2 class="font-semibold mb-2">Como Funciona:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Código gerado por aplicativo autenticador (ex: Microsoft Authenticator, Google Authenticator)</li>
            <li>Código válido por cerca de 30 segundos, renovando a cada período</li>
            <li>É necessário informar o código gerado pelo app a cada login após ativar o 2FA</li>
            <li>O sistema fornece 8 códigos de recuperação que podem ser usados caso não tenha acesso ao app <br>
                Guarde esses códigos em um local seguro e use somente em situações de emergência. <br>
                Cada código pode ser utilizado apenas uma vez.
            </li>
        </ul>
        <h2 class="font-semibold mb-2">Configurando 2FA:</h2>
        <ol class="list-decimal pl-6 space-y-2 mb-8 text-gray-800">
            <li><strong>Acesse Configurações de Segurança:</strong> Vá para seu Perfil → Autenticação de Dois Fatores</li>
            <li><strong>Inicie o processo:</strong> Clique em "Habilitar"</li>
            <li><strong>Confirme Seu Telefone/App:</strong> Insira sua chave de configuração ou escaneie o QR code</li>
            <li><strong>Insira o Código de Verificação:</strong> Digite o código gerado e clique em "Confirmar"</li>
            <li><strong>Guarde Códigos de Recuperação:</strong> Salve os códigos em local seguro para caso perca acesso ao seu telefone</li>
        </ol>

        <h1 class="text-xl font-bold mb-4">
            Gerenciamento de Sessões e Dispositivos
        </h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            Monitore e controle os dispositivos e sessões ativas em sua conta, conhecendo o endereço IP, sistema operacional e navegador:
        </p>
        <div class="space-y-3 bg-gray-50 p-4 rounded-lg text-gray-800">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold">Ubuntu - Firefox</p>
                    <p class="text-sm">
                        192.168.1.105, <span class="text-green-800 font-semibold">Essa sessão</span>
                    </p>

                </div>
            </div>
            <hr class="border-gray-200">
            <div class="flex justify-between items-start">
                <div>
                    <p class="font-semibold">AndroidOS - Chrome</p>
                    <p class="text-sm">192.168.42.129, Última atividade há 11 segundos </p>
                </div>
            </div>
        </div>
        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4 text-red-800">
            <p class="font-semibold">
                Atividade Suspeita?
            </p>
            <p class="text-sm leading-relaxed">
                Se vir um dispositivo ou localização desconhecida, clique em "Sair de outras sessões do navegador" para encerrar outras sessões além da atual imediatamente.
                Se você acha que sua conta foi comprometida, você também deve atualizar sua senha.
            </p>
        </div>
    </article>

    {{-- Seção 4 --}}
    <article id="calendar" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">4. Agenda de Avaliações</h1>

        <h2 class="text-xl font-semibold mb-4">Visualização mensal</h2>
        <p class="leading-relaxed mb-2">
            Após o login bem-sucedido, você acessará a <strong>Agenda de Avaliação</strong>, que é sua tela inicial no sistema.
        </p>
        <p class="leading-relaxed mb-2">
            A tela exibe um <strong>calendário mensal</strong> onde você pode:
        </p>
        <ul class="list-disc pl-6 space-y-1 text-gray-800">
            <li>Ver rapidamente quais Bancas Agendadas ocorrerão em cada dia do mês</li>
            <li>Identificar dias com múltiplas avaliações</li>
            <li>Planejar sua agenda com antecedência</li>
        </ul>
        <h3 class="font-semibold mb-2">Elementos da tela:</h3>
        <ul class="list-disc pl-6 space-y-1 mb-8 text-gray-800">
            <li>Centralizar o gerenciamento de avaliações acadêmicas</li>
            <li>Padronizar critérios e rubricas de avaliação</li>
            <li>Facilitar o agendamento de bancas avaliativas</li>
            <li>Organizar dados de alunos, professores e coordenadores</li>
            <li>Gerar análises e relatórios de desempenho</li>
        </ul>

        <h2 class="text-xl font-semibold mb-4">Visualização Diária</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Para ver mais detalhes sobre um dia específico:
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-4 text-gray-800">
            <li>Clique no dia desejado no calendário mensal</li>
            <li>Você verá o cronograma horário daquele dia</li>
            <li>Visualize horários disponíveis e bancas agendadas</li>
        </ol>
        <p class="leading-relaxed mb-2 text-gray-800 font-bold">
            Para agendar uma nova banca:
        </p>
        <ol class="list-decimal pl-6 space-y-1 text-gray-800">
            <li>Selecione um horário disponível</li>
            <li>Clique em "AGENDAR NOVA BANCA"</li>
            <li>Preencha as informações solicitadas</li>
            <li>Confirme o agendamento</li>
        </ol>
    </article>

    {{-- Seção 5 --}}
    <article id="users" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">5. Gerenciamento de Usuários</h1>

        <h1 class="text-xl font-bold mb-4">Cadastro de Alunos</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Visualizando a Lista de Alunos:</strong>
        </p>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela "Alunos Cadastrados" exibe uma tabela com colunas de RA, Nome, E-mail, Grupo, Curso, Estado e Ações.
        </p>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Filtros Disponíveis:</strong>
        </p>
        <ul class="list-disc pl-6 space-y-2 mb-4 text-gray-800">
            <li>Busca por Nome - Digite o nome do aluno</li>
            <li>Filtro por Curso - Selecione um curso específico</li>
            <li>Filtro por Grupo - Visualize alunos de um grupo</li>
            <li>Filtro por Período - Escolha o período/semestre</li>
            <li>Filtro por Estado - Mostrar ativos ou inativos</li>
        </ul>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Cadastrando um Novo Aluno:</strong>
        </p>
        <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800">
            <li>Clique no botão "CADASTRAR"</li>
            <li>Preencha o modal com RA, Nome, E-mail, Grupo e Curso</li>
            <li>Clique em "SALVAR" para confirmar ou "FECHAR" para cancelar</li>
        </ol>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Alterando ou Inativando Alunos:</strong>
        </p>
        <ul class="list-disc pl-6 space-y-2 mb-8 text-gray-800">
            <li>Use o botão "ALTERAR" para editar informações</li>
            <li>Use o botão "INATIVAR" para desativar o acesso (não deleta dados)</li>
        </ul>

        <h1 class="text-xl font-bold mb-4">Cadastro de Professores</h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela <strong>"Professores Cadastrados"</strong> funciona de forma similar ao cadastro de alunos.
        </p>
        <h2 class="font-semibold mb-2">Funcionalidades:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Visualizar tabela com Nome, E-mail, Departamento, Estado</li>
            <li>Buscar professores por nome</li>
            <li>ALTERAR - Editar informações do professor</li>
            <li>INATIVAR - Desativar acesso do professor</li>
            <li>ATIVAR - Reativar professores inativos</li>
        </ul>
        <p class="leading-relaxed mb-8 text-gray-800">
            <strong>Processo de cadastro:</strong> CADASTRAR → Preencher modal → SALVAR
        </p>

        <h1 class="text-xl font-bold mb-4">Cadastro de Coordenadores</h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela <strong>"Coordenadores Cadastrados"</strong> gerencia os coordenadores do sistema.
        </p>
        <h2 class="font-semibold mb-2">Funcionalidades:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Listar coordenadores com nome e e-mail</li>
            <li>Filtrar e buscar coordenadores</li>
            <li>ALTERAR - Editar dados do coordenador</li>
            <li>INATIVAR - Controlar acesso ao sistema</li>
        </ul>
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4 text-blue-800">
            <p class="font-semibold">
                Permissões
            </p>
            <p class="text-sm leading-relaxed">
                Coordenadores têm acesso a funcionalidades administrativas como gerenciar cursos, grupos, bancas e rubricas.
            </p>
        </div>
    </article>

    {{-- Seção 6 --}}
    <article id="institutional" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">6. Configurações Institucionais</h1>

        <h1 class="text-xl font-bold mb-4">Gerenciamento de Cursos</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Cursos Cadastrados"</strong> centraliza todos os cursos oferecidos.
        </p>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Tabela de Cursos contém:</strong>
        </p>
        <ul class="list-disc pl-6 space-y-2 mb-8 text-gray-800">
            <li>
                <strong>ID -</strong> Nome do curso
            </li>
            <li>
                <strong>Nome -</strong> Manhã, Tarde ou Noite
            </li>
            <li>
                <strong>Coordenador -</strong> Coordenador responsável
            </li>
            <li>
                <strong>Estado -</strong> Ativo ou Inativo
            </li>
            <li>
                <strong>Ações -</strong> ALTERAR / INATIVAR / ATIVAR
            </li>
        </ul>

        <h1 class="text-xl font-bold mb-4">Gerenciamento de Grupos</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Cadastro de Grupos"</strong> exibe os grupos em formato de cartões.
        </p>
        <h2 class="font-semibold mb-2">Informações em cada cartão:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Nome do grupo</li>
            <li>Número de membros</li>
            <li>Lista de integrantes</li>
            <li>Status (Ativo/Inativo)</li>
        </ul>
        <h2 class="font-semibold mb-2">Ações por grupo:</h2>
        <ul class="list-disc pl-6 mb-8 space-y-2 text-gray-800">
            <li>ALTERAR - Editar informações e membros</li>
            <li>INATIVAR - Desativar o grupo</li>
            <li>ATIVAR - Reativar grupos inativos</li>
        </ul>

        <h1 class="text-xl font-bold mb-4">
            Gerenciamento de Bancas
        </h1>
        <p class="leading-relaxed mb-4 text-gray-800">
            A tela <strong>"Bancas Cadastradas"</strong> gerencia todas as bancas de avaliação.
        </p>
        <h2 class="font-semibold mb-2">Informações em cada cartão:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Nome da banca (Ex: "Banca 01", "Banca 02")</li>
            <li>Criador - Quem criou a banca</li>
            <li>Número de membros</li>
            <li>Lista de integrantes com papéis (Coordenador ou Membro)</li>
        </ul>
        <h2 class="font-semibold mb-2">Ações por grupo:</h2>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>ALTERAR - Editar informações e membros</li>
            <li>INATIVAR - Desativar o grupo</li>
            <li>ATIVAR - Reativar grupos inativos</li>
        </ul>
    </article>

    {{-- Seção 7 --}}
    <article id="rubrics" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">7. Critérios e Rubricas</h1>

        <h2 class="text-xl font-semibold mb-4">Conceitos Fundamentais</h2>
        <div class="space-y-1 mb-8 text-gray-800">
            <p><strong>Critério:</strong> Um aspecto específico do desempenho que será avaliado (Ex: "Qualidade da documentação técnica")</p>
            <p><strong>Eixo:</strong> Agrupamento de critérios relacionados (Ex: "Eixo 1: Documentação e Apresentação")</p>
            <p><strong>Rubrica:</strong> Conjunto completo de eixos e critérios para avaliar grupos ou indivíduos</p>
        </div>


        <h2 class="text-xl font-semibold mb-4">Cadastro de Critérios</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Critérios Cadastrados"</strong> permite:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Visualizar todos os critérios do sistema</li>
            <li>Criar novos critérios de avaliação</li>
            <li>Editar critérios existentes</li>
            <li>Associar critérios aos eixos</li>
        </ul>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Exemplo de critério:</strong>
        </p>
        <ul class="list-disc pl-6 mb-8 space-y-2 text-gray-800">
            <li>Nome: Qualidade da documentação técnica</li>
            <li>Descrição: Avalia a clareza, completude e precisão</li>
            <li>Tipo: Técnico</li>
        </ul>

        <h2 class="text-xl font-semibold mb-4">Cadastro de Eixos</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            A tela <strong>"Eixos Cadastrados"</strong> organiza os critérios:
        </p>
        <ul class="list-disc pl-6 mb-4 space-y-2 text-gray-800">
            <li>Criar novos eixos de avaliação</li>
            <li>Agrupar critérios relacionados</li>
            <li>Definir a ordem de apresentação</li>
            <li>Gerenciar eixos ativos e inativos</li>
        </ul>
    </article>

    {{-- Seção 8 --}}
    <article id="evaluation" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">8. Processo de avaliação</h1>

        <h2 class="text-xl font-semibold mb-2">Avaliação de Grupo</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Acessando a Rubrica de Grupo:</strong>
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-4 text-gray-800">
            <li>Navegue até a seção de avaliações</li>
            <li>Selecione o grupo a ser avaliado</li>
            <li>Clique em "INICIAR AVALIAÇÃO"</li>
        </ol>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Preenchendo a Rubrica:</strong>
        </p>
        <p class="leading-relaxed mb-4 text-gray-800">
            A rubrica é organizada por Eixos, cada um contendo vários critérios.
        </p>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Preenchendo a Rubrica:</strong>
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-8 text-gray-800">
            <li>Para cada critério, selecione o nível de desempenho</li>
            <li>Insatisfatório - Desempenho abaixo do esperado</li>
            <li>Regular - Desempenho aceitável"</li>
            <li>Bom - Desempenho acima da expectativa</li>
            <li>Excelente - Desempenho excepcional</li>
        </ol>

        <h2 class="text-xl font-semibold mb-2">Avaliação individual</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Acessando a Rubrica Individual:</strong>
        </p>
        <p class="leading-relaxed mb-4 text-gray-800">
            Após avaliar o grupo, você passará para a <strong>avaliação individual</strong> dos membros.
        </p>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Procedimento:</strong>
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-4 text-gray-800">
            <li>Localize cada aluno na tabela</li>
            <li>Para cada critério, selecione o nível de desempenho</li>
            <li>As seleções aparecem destacadas indicando notas individuais</li>
            <li>Você pode adicionar comentários ou notas específicas</li>
        </ol>
        <p class="leading-relaxed mb-2 text-gray-800">
            <strong>Preenchendo a Rubrica:Finalizando a Avaliação:</strong>
        </p>
        <ol class="list-decimal pl-6 space-y-1 mb-2 text-gray-800">
            <li>Revise todas as notas e critérios</li>
            <li>Clique em "SALVAR AVALIAÇÃO" para registrar tudo no sistema</li>
            <li>Ou "FECHAR" para sair sem salvar</li>
        </ol>
        <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4 text-red-800">
            <p class="font-semibold">
                Importante
            </p>
            <p class="text-sm leading-relaxed">
                Importante: Clique em "SALVAR AVALIAÇÃO" para que todas as informações sejam gravadas no sistema.
                Sem isso, os dados serão perdidos.
            </p>
        </div>
    </article>

    {{-- Seção 9 --}}
    <article id="profile" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl mb-8 font-bold">9. Perfil</h1>

        <h2 class="text-xl font-semibold mb-4">Dados do Perfil</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Acesse e edite suas informações pessoais.
        </p>
        <h2 class="font-semibold mb-2">Como Acessar:</h2>
        <ol class="list-decimal pl-6 mb-4 space-y-2 text-gray-800">
            <li>Clique no ícone de <strong>Perfil</strong> (canto superior direito)</li>
            <li>Selecione <strong>"Meu Perfil"</strong> ou <strong>"Editar Perfil"</strong></li>
        </ol>
        <h2 class="font-semibold mb-2">Informações editáveis:</h2>
        <ul class="list-disc pl-6 mb-8 space-y-2 text-gray-800">
            <li>Nome completo</li>
            <li>E-mail</li>
            <li>Telefone</li>
            <li>Foto de perfil</li>
        </ul>

        <h2 class="text-xl font-semibold mb-4">Foto de Perfil</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Personalize sua foto de perfil no sistema.
        </p>
        <ol class="list-decimal pl-6 mb-4 space-y-2 text-gray-800">
            <li>Acesse Editar Perfil: Vá para seu Perfil → Editar Perfil</li>
            <li>Clique na Foto Atual: Clique no avatar para trocar a imagem</li>
            <li>Selecione Uma Imagem: Escolha uma foto do seu computador (JPG, PNG - máx. 5MB)</li>
            <li>Corte e Confirme: Ajuste o corte da imagem conforme necessário e salve</li>
        </ol>
        <div class="mt-6 mb-8 bg-amber-50 border border-amber-200 rounded-lg p-4 text-amber-800">
            <p class="font-semibold">
                Requisitos da Foto
            </p>
            <p class="text-sm leading-relaxed">
                Formatos aceitos: jpg, jpeg, png | Tamanho máximo: 1MB | Recomendado: 200x200px ou maior
            </p>
        </div>

        <h2 class="text-xl font-semibold mb-4">Preferências Pessoais</h2>
        <p class="leading-relaxed mb-2 text-gray-800">
            Customize suas preferências de experiência no SIRUS:
        </p>
        <div class="space-y-4">
            <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white">Notificações por E-mail</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Receba alertas sobre atividades importantes</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white">Resumos Semanais</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Receba um resumo das atividades da semana</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800 p-4 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <h4 class="font-semibold text-slate-900 dark:text-white">Lembretes de Avaliações</h4>
                        <p class="text-sm text-slate-600 dark:text-slate-400">Aviso antecipado sobre avaliações agendadas</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" checked>
                        <div class="w-11 h-6 bg-slate-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-slate-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-blue-600"></div>
                    </label>
                </div>
            </div>
        </div>
    </article>

    {{-- Seção 10 --}}
    <article id="accessibility" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl font-bold">10. Acessibilidade</h1>

        <h1 class="text-xl font-bold mb-4">Modo Escuro</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            Reduz o cansaço visual em ambientes com pouca luz e melhora a experiência de uso à noite.
        </p>
        <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800">
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

        <h1 class="text-xl font-bold mb-4">Filtros para Daltonismo</h1>
        <p class="leading-relaxed mb-2 text-gray-800">
            O SIRUS oferece filtros especiais para usuários com deficiência de visão de cores.
            O daltonismo é uma condição visual que altera a forma como as cores são percebidas.
            Ele afeta cerca de 8% dos homens e 0,5% das mulheres. Para tornar a navegação mais confortável,
            oferecemos filtros de simulação que ajudam a ajustar a visualização conforme cada tipo de daltonismo.
        </p>
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
        <ol class="list-decimal pl-6 space-y-2 mb-4 text-gray-800">
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
        <p class="leading-relaxed mb-4 text-gray-800">
            O ícone do assistente aparece em todas as páginas, no lado direito da tela, próximo ao ícone de daltonismo.
            Você pode ocultá-lo a qualquer momento acessando Perfil → Acessibilidade.
            Essa preferência é salva apenas no navegador atual. Se você ocultar o ícone e depois acessar o sistema em outro navegador, ele voltará a aparecer.
        </p>

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

    {{-- Seção 11 --}}
    <article id="support" class="chapter bg-white shadow rounded-xl border border-gray-200 p-16 text-gray-900 scroll-mt-[4.5rem]">
        <h1 class="text-3xl font-bold mb-4">11. Suporte</h1>

        <h1 class="text-xl font-bold mb-4">Perguntas Frequentes</h1>
        <div class="space-y-4 mb-4 text-gray-800">
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

    {{-- Seção 2: Contato e Suporte
    <article class="bg-white shadow rounded-xl border border-gray-200 p-8 text-gray-900">
        <h1 class="text-xl font-bold mb-4">Contato e Suporte</h1>
        <p class="leading-relaxed mb-6 text-gray-800">
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
    </article>--}}

        <h1 class="text-xl font-bold mb-4">Glossário de Termos</h1>
        <div class="space-y-4 text-gray-800">
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
    </article>
</x-documentation-layout>
