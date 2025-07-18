# Sistema de Gestão de Grupos Económicos

Este é um sistema web desenvolvido em Laravel para a gestão de uma estrutura corporativa hierárquica, incluindo Grupos Económicos, Bandeiras, Unidades e Colaboradores.

## Finalidade do Sistema

Este sistema foi projetado para ser uma ferramenta central de **Gestão de Estrutura Organizacional e de Recursos Humanos (RH)**, ideal para empresas com uma estrutura complexa. Ele resolve o problema de ter informações críticas de RH espalhadas em múltiplas planilhas e sistemas legados, oferecendo uma fonte única de verdade, controlo de acesso e um rastro de auditoria completo.

Para ilustrar, imagine um grande grupo de varejo:

- **Grupo Econômico:** "Varejo Brasil S.A." (a holding que controla tudo).
- **Bandeiras:** "Supermercados Luxo", "Lojas Populares", "Eletrônicos Tech" (marcas diferentes pertencentes ao mesmo grupo).
- **Unidades:** "Loja Luxo - Shopping Morumbi", "Loja Popular - Centro" (as lojas físicas, cada uma com seu CNPJ e associada a uma bandeira).
- **Colaboradores:** "João da Silva", "Maria Oliveira" (os funcionários, cada um alocado na sua unidade de trabalho).

O sistema permite que o RH e os gestores administrem esta estrutura complexa de forma centralizada e segura.

## Funcionalidades

- **Autenticação:** Sistema completo de registo e login de utilizadores.
- **Gestão de Grupos Económicos:** CRUD completo (Criar, Ler, Atualizar, Apagar).
- **Gestão de Bandeiras:** CRUD completo com associação a um Grupo Económico.
- **Gestão de Unidades:** CRUD completo com associação a uma Bandeira.
- **Gestão de Colaboradores:** CRUD completo com associação a uma Unidade.
- **Relatório de Colaboradores:** Página de relatórios com filtros dinâmicos e em cascata.
- **Auditoria:** Registo automático de todas as criações, atualizações e exclusões de dados no sistema.
- **Exportação para Excel:** Funcionalidade de exportação dos relatórios filtrados.
- **Processamento em Segundo Plano:** As exportações de relatórios são processadas em filas para não bloquear o utilizador.
- **Interface Dinâmica:** Utilização de Livewire para filtros e interações em tempo real sem recarregar a página.
- **Testes Automatizados:** Cobertura de testes de funcionalidade para garantir a integridade e estabilidade da aplicação.

## Tecnologias Utilizadas

- **Backend:** Laravel 10
- **Frontend:** Blade, Tailwind CSS, Alpine.js, Livewire
- **Base de Dados:** MySQL
- **Ambiente de Desenvolvimento:** Docker com Laravel Sail
- **Testes:** Pest (PHPUnit)
- **Outros Pacotes:**
    - `laravel/breeze` para autenticação.
    - `owen-it/laravel-auditing` para o sistema de auditoria.
    - `maatwebsite/excel` para exportação de dados.

## Pré-requisitos

- Docker
- Composer

## Instalação

Siga os passos abaixo para configurar o ambiente de desenvolvimento localmente.

1.  **Clonar o Repositório**
    ```bash
    git clone [https://github.com/seu-usuario/seu-repositorio.git](https://github.com/seu-usuario/seu-repositorio.git)
    cd seu-repositorio
    ```

2.  **Copiar o Ficheiro de Ambiente**
    ```bash
    cp .env.example .env
    ```

3.  **Instalar Dependências do PHP**
    ```bash
    docker run --rm \
        -u "$(id -u):$(id -g)" \
        -v "$(pwd):/var/www/html" \
        -w /var/www/html \
        laravelsail/php82-composer:latest \
        composer install --ignore-platform-reqs
    ```

4.  **Iniciar os Contentores do Sail**
    Isto irá iniciar o servidor web, a base de dados e outros serviços.
    ```bash
    ./vendor/bin/sail up -d
    ```

5.  **Gerar a Chave da Aplicação**
    ```bash
    ./vendor/bin/sail artisan key:generate
    ```

6.  **Executar as Migrações e Seeders**
    Isto irá criar todas as tabelas na base de dados.
    ```bash
    ./vendor/bin/sail artisan migrate --seed
    ```

7.  **Instalar Dependências do Frontend e Compilar**
    ```bash
    ./vendor/bin/sail npm install
    ./vendor/bin/sail npm run dev
    ```

8.  **Iniciar o Worker da Fila (Opcional, para desenvolvimento)**
    Para que as exportações de Excel funcionem, precisa de ter um worker a correr num terminal separado.
    ```bash
    ./vendor/bin/sail artisan queue:work
    ```

A aplicação estará agora acessível em **[http://localhost](http://localhost)**.

## Como Usar

1.  Acesse **[http://localhost](http://localhost)** no seu navegador.
2.  Clique em **"Register"** no canto superior direito para criar uma nova conta de utilizador.
3.  Após o registo, será redirecionado para o painel de controlo (dashboard).
4.  Utilize o menu de navegação no topo para aceder às diferentes secções de gestão (Grupos Económicos, Bandeiras, Relatórios, etc.).

## Testes

O projeto tem uma suíte de testes automatizados para garantir a qualidade do código. Para executar todos os testes, corra o seguinte comando:

```bash
./vendor/bin/sail artisan test
