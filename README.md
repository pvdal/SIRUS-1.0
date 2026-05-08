<p align="center">
  <picture>
    <source media="(prefers-color-scheme: dark)" srcset="public/img/logo_readme_dark.svg">
    <source media="(prefers-color-scheme: light)" srcset="public/img/logo_readme_light.svg">
    <img src="public/img/Logo_readme_light.svg" width="250" alt="SIRUS Logo">
  </picture>
</p>

<p align="center">
  <a href="https://laravel.com/"><img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=red"></a>
  <a href="https://www.php.net/"><img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=777BB4"></a>
  <a href="https://docs.github.com/pt/repositories/managing-your-repositorys-settings-and-features/customizing-your-repository/licensing-a-repository"><img src="https://img.shields.io/badge/License-Proprietary-2f2f2f?style=for-the-badge&logo=github&logoColor=white"></a>
</p>

## Sobre o projeto

O SIRUS é uma plataforma web desenvolvida para otimizar e padronizar o processo de avaliação acadêmica dos trabalhos apresentados no SIMBAJU (Simpósio da Bacia do Juquery), evento realizado semestralmente na FATEC Franco da Rocha.

O sistema soluciona a fragmentação de dados ao centralizar o gerenciamento das avaliações, permitindo que coordenadores, professores e alunos interajam em um ambiente unificado e confiável.

### Funcionalidades principais

- **Gestão de Rubricas:** Estruturação de critérios e eixos avaliativos (individual e em grupo) com pesos percentuais.
- **Agenda Interativa:** Calendário dinâmico para agendamento e visualização de bancas examinadoras.
- **Segurança:** Implementação de Autenticação em Dois Fatores (2FA) via aplicativos autenticadores e gestão de sessões ativas.
- **Gestão de Arquivos:** Upload, organização e visualização de trabalhos acadêmicos em formato PDF.
- **Acessibilidade:** Filtros para daltonismo e integração com VLibras.

### Tecnologias Utilizadas

<p align="left">
  <img src="https://skillicons.dev/icons?i=php,laravel,mysql,js,tailwind,nodejs,nginx,git,github&theme=dark" />
</p>

## Como rodar o projeto (Desenvolvimento)

Este guia assume que você está em um ambiente de desenvolvimento local.

### 1. Requisitos do Sistema

Antes de começar, certifique-se de ter instalado:
- PHP 8.3+ (com extensões: `fpm`, `mysql`, `xml`, `curl`, `mbstring`, `zip`, `bcmath`, `intl`, `gd`, `soap`).
- Node.js (versão 22.x recomendada) e npm.
- Composer (Gerenciador de dependências PHP).
- MySQL/MariaDB.
- Git.

### 2. Instalação e Configuração Local  

Siga os passos abaixo no terminal dentro do diretório do projeto.

1. Clonar o repositório
```bash
git clone https://github.com/pvdal/SIRUS-1.0
cd SIRUS-1.0
```

2. Configurar o arquivo de ambiente  
  - No Linux
  ```bash    
  cp .env.example .env
  ```

  - No Windows
  ```bash    
  copy .env.example .env
  ```

  > [!IMPORTANT]
  > Edite o arquivo `.env` com suas credenciais de banco de dados e SMTP.
  > Consulte os guias em [`/docs`](/docs) para configuração detalhada do ambiente.
    
3. Instalar dependências do Backend (PHP)
  ```bash    
  composer install
  ```

4. Instalar dependências do Frontend (Javascript/CSS)
  ```bash    
  npm install
  ```

5. Inicializar o Laravel e Banco de Dados
  ```bash  
  php artisan key:generate
  php artisan storage:link
  php artisan migrate --seed
  ```
6. Build e otimização (cache)
  ```bash  
  npm run build
  php artisan optimize:clear
  php artisan optimize
  ```

> [!NOTE]
> O sistema exige permissões de escrita nos diretórios `storage` e `bootstrap/cache` para o usuário do servidor (ex: `www-data` no Linux).

### 3. Executando em Desenvolvimento

Para rodar o sistema localmente, você precisará de dois processos rodando em terminais separados.
  - Servidor Web (acessível em http://localhost:8000)
  ```bash    
  php artisan serve
  ```
  - Processamento de Filas (obrigatório para envio de e-mails)
  ```bash    
  php artisan queue:work --verbose --tries=3 --timeout=90 --sleep=3
  ```

## Estrutura do Projeto

O SIRUS segue o padrão MVC do Laravel, com organização voltada à separação clara das responsabilidades.

```md

📁 SIRUS-1.0
├── 📁 app
│ ├── 📁 Http
│ │ ├── 📁 Controllers # Fluxo das requisições e regras de negócio
│ │ └── 📁 Middleware # Regras de interceptação
│ ├── 📁 Services # Regras de negócio
│ └── 📁 Models # Entidades do sistema (Aluno, Professor, etc)
│
├── 📁 resources
│ └── 📁 views # Interface (Blade + componentes)
│
├── 📁 routes # Rotas do sistema
├── 📁 database
│ ├── 📁 migrations # Estrutura do banco
│ └── 📁 seeders # Dados iniciais
│
├── 📁 storage # Logs e arquivos (PDFs)
├── 📁 public # Entrada da aplicação
├── 📁 docs # Guias técnicos

```  

## Documentação Técnica

Este repositório conta com guias detalhados para configuração e preparação do ambiente do sistema.

- [Inicialização do projeto](docs/init-sirus.txt)
- [Preparação de ambiente (Ubuntu)](docs/setup-ubuntu.txt)
- [Configuração do PHP](docs/php-config.txt)
- [Configuração do Nginx](docs/nginx-config.txt)
- [Configuração de filas (Supervisor)](docs/queues-config.txt)
- [Configuração do .env para produção](docs/env-production.txt)
- [Preparação para produção](docs/setup-production.txt)

## Contribuição

Este é um projeto estritamente **acadêmico** desenvolvido como parte do currículo da faculdade. No momento, o repositório serve apenas para fins de exibição de portfólio e não está aberto a contribuições externas ou modificações.

## Licença e Direitos Autorais (Copyright)

**Este software NÃO é de código aberto (Open Source).**

Este repositório é disponibilizado **sem concessão de licença de uso**. De acordo com a **Lei Brasileira de Direitos Autorais (Lei nº 9.610/98)**, os programas de computador são obras intelectuais protegidas e sua proteção independe de registro.
- **Propriedade:** Todos os direitos patrimoniais e morais pertencem exclusivamente aos autores deste grupo acadêmico.
- **Uso Proibido:** É terminantemente proibida a reprodução, distribuição, modificação ou **utilização comercial (lucro direto ou indireto)** deste código sem autorização prévia e expressa.
- **Portfólio:** A publicação no GitHub visa apenas a demonstração de competências técnicas. O direito de "fork" permitido pelos Termos de Serviço do GitHub restringe-se à visualização e não confere permissão para uso, compartilhamento ou exploração econômica.

## Autores

**Desenvolvimento**
- [Pedro Lima](https://github.com/pvdal)
- [Felipe Rocha](https://github.com/FelipRNS)

**Contribuições em Pesquisa e Modelagem**
- [Pedro Borges](https://github.com/PedroG2224)
- [Rennan Melo](https://github.com/rennans-afk)
