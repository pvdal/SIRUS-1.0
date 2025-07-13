<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta charset="UTF-8">

        <title>SIRUS - Sistema de Avaliação Acadêmica</title>
        <link rel="icon" type="image/png" href="{{ asset('logo.png') }}?v=1">

        <!-- Bootstrap 5 CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
        <!-- Google Fonts -->

        @vite(['resources/css/home.css'])
    </head>
    <body>
        <!-- Hero Section -->
        <section class="hero-section" >
            <div class="container hero-content">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="logo-container text-center">
                            <x-authentication-card-logo />
                            <h1 class=" text-white mt-3 mb-0" style="font-size: 3.5rem; font-weight: 700;">SIRUS</h1>
                            <p class=" text-white text-50 mb-0">Sistema de Rubricas para Gestão Avaliativa do SIMBAJU</p>
                        </div>
                    </div>
                    <div class="col-lg-6" >
                        <div class="text-welcome text-left">
                            <h2 class=" mb-4" style="font-size: 2.5rem; font-weight: 600;">
                                Bem-vindo ao sistema SIRUS
                            </h2>
                            <p class="text-50 mb-4 fs-5">
                                Uma plataforma intuitiva para gerenciar, aplicar e analisar avaliações acadêmicas com eficiência e padronização.
                            </p>
                            <div class="d-flex gap-3 flex-wrap">
                                <a class="text-white btn btn-primary-custom btn-lg" href="/login">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>
                                    @auth
                                        Dashboard
                                    @else
                                        Fazer Login
                                    @endauth
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="py-5" style="padding: 5rem 0;">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="section-title" style="font-size: 2.5rem; font-weight: 600; color: var(--text-dark);">
                            Recursos Principais
                        </h2>
                        <p class="text-muted fs-5 mb-5">Descubra as funcionalidades o SIRUS oferece</p>
                    </div>
                </div>

                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-clipboard-check text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Criação de Avaliações</h4>
                            <p class="text-muted">
                                Crie avaliações personalizadas com diferentes tipos de critérios, incluindo apresentação, argumentação, clareza conceitual e participação.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-people-fill text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Gestão de Usuários</h4>
                            <p class="text-muted">
                                Cadastro e gerenciamento completo de alunos, professores e coordenadores com diferentes níveis de acesso e permissões específicas para cada perfil.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-calendar-event text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Agenda de Bancas</h4>
                            <p class="text-muted">
                                Organização e agendamento de bancas avaliadoras com definição de membros, datas e grupos, facilitando o acompanhamento das apresentações.
                            </p>
                        </div>
                    </div>


                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-graph-up-arrow text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Análise de Resultados</h4>
                            <p class="text-muted">
                                Relatórios detalhados e análises estatísticas para acompanhar o desempenho dos estudantes.
                            </p>
                        </div>
                    </div>

                    {{--
                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-shield-check text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Segurança Avançada</h4>
                            <p class="text-muted">
                                Proteção contra fraudes com monitoramento em tempo real e medidas de segurança robustas.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-cloud-arrow-up text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Backup Automático</h4>
                            <p class="text-muted">
                                Seus dados sempre seguros com backup automático e sincronização em nuvem.
                            </p>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6">
                        <div class="feature-card">
                            <div class="feature-icon">
                                <i class="bi bi-device-tablet text-white" style="font-size: 1.5rem;"></i>
                            </div>
                            <h4 class="mb-3" style="color: var(--text-dark); font-weight: 600;">Multi-plataforma</h4>
                            <p class="text-muted">
                                Acesse de qualquer dispositivo - computador, tablet ou smartphone com total responsividade.
                            </p>
                        </div>
                    </div>

                    --}}
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="stats-section">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="section-title" style="font-size: 2.5rem; font-weight: 600; color: var(--text-dark);">
                            O que é o SIMBAJU?
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="stat-item">
                            <p class="text-muted">
                                O Simpósio da Bacia do Juquery (SIMBAJU) é um evento acadêmico-científico realizado semestralmente na Faculdade de Tecnologia de Franco da Rocha,
                                no estado de São Paulo. A instituição de ensino superior promove, com a apresentação dos trabalhos dos alunos, uma troca de conhecimento
                                entre alunos e especialistas, ajudando os participantes e ouvintes a terem uma formação mais sólida na área.
                            </p>
                        </div>
                    </div>
                    {{--
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <span class="stat-number">200+</span>
                            <h5 style="color: var(--text-dark); font-weight: 500;">Instituições</h5>
                            <p class="text-muted">Escolas e universidades confiam no SIRUS</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <span class="stat-number">99.9%</span>
                            <h5 style="color: var(--text-dark); font-weight: 500;">Uptime</h5>
                            <p class="text-muted">Disponibilidade garantida quando você precisar</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="stat-item">
                            <span class="stat-number">24/7</span>
                            <h5 style="color: var(--text-dark); font-weight: 500;">Suporte</h5>
                            <p class="text-muted">Equipe sempre pronta para ajudar</p>
                        </div>
                    </div>
                    --}}
                </div>
            </div>
        </section>
        {{--
        <!-- CTA Section -->
        <section class="py-5" style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); padding: 5rem 0;">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2 class="text-white mb-4" style="font-size: 2.5rem; font-weight: 600;">
                            Pronto para revolucionar suas avaliações?
                        </h2>
                        <p class="text-white-50 mb-4 fs-5">
                            Junte-se a centenas de instituições que já transformaram seu processo de avaliação com o SIRUS.
                        </p>
                        <div class="d-flex gap-3 justify-content-center flex-wrap">
                            <button class="btn btn-light btn-lg px-4">
                                <i class="bi bi-person-plus me-2"></i>
                                Criar Conta Gratuita
                            </button>
                            <button class="btn btn-outline-light btn-lg px-4">
                                <i class="bi bi-telephone me-2"></i>
                                Falar com Especialista
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        --}}
        <!-- Footer -->
        <footer class="bg-dark text-white py-4">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center">
                            <x-authentication-card-logo size="40" class="me-2"/>
                            <span style="font-weight: 600; font-size: 1.2rem;">SIRUS</span>
                        </div>
                        <p class="mb-0 mt-2 text-white"> &copy; 2024 SIRUS. Todos os direitos reservados.</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <div class="d-flex justify-content-md-end gap-3">
                            <a href="{{ route('policy.show') }}" class="text-white-50 text-decoration-none">Política de Privacidade</a>
                            <a href="{{ route('terms.show') }}" class="text-white-50 text-decoration-none">Termos de Uso</a>
                            {{-- <a href="#" class="text-white-50 text-decoration-none">Suporte</a> --}}
                        </div>
                    </div>
                </div>
            </div>
        </footer>

        {{-- Bootstrap 5 JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
