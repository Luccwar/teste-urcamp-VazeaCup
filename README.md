<a href="https://github.com/Luccwar/teste-urcamp-VazeaCup/blob/main/README_EN.md"><img alt="Change Language to English" src="https://img.shields.io/badge/lang-en-darkred"></a> <a href="https://github.com/Luccwar/teste-urcamp-VazeaCup/blob/main/README.md"><img alt="Mudar Língua para o Português Brasileiro" src="https://img.shields.io/badge/lang-pt--br-darkgreen" ></a>

# Varzea Cup

Olá, este projeto foi desenvolvido como parte de uma avaliação para a Urcamp. Destaco que o projeto em PHP puro está completo, contudo, devido a complicações durante o desenvolvimento, foi possível apenas criar a API deste, sem um front-end para consumir os dados.

## Tabelas de Conteúdo

- [Funcionalidades](#funcionalidades)
- [Instalação](#instalação)
- [Rodar o Projeto](#rodar-o-projeto)

## Funcionalidades

No projeto atual, você pode criar, editar, excluir e listar cadastros de usuários, times e partidas em um campeonato. As informações do campeonato são calculadas dinamicamente em suas respectivas páginas relevantes.

É importante ressaltar que o usuário deve estar logado para acessar as rotas de usuários, times e partidas. Caso o usuário não esteja autenticado, ele poderá apenas visualizar a página inicial e a página de login.

Todos os formulários de criação e edição de cadastros no projeto dentro da pasta VarzeaCup, possuem validações para garantir a integridade dos dados.

## Instalação

### 1. Pré-requisitos

Certifique-se de ter os seguintes requisitos instalados:

- PHP 8.3 e Laravel 11 - O projeto foi desenvolvido com estas versões dos frameworks. É possível que funcione com versões anteriores, mas não é garantido;
- Composer em sua versão mais atualizada;
- Banco de Dados Relacional PostgreSQL 16 e pgAdmin4;
- NodeJS em sua versão mais atualizada.

### 2. Passos para instalar o projeto

- Clone o repositório:

```bash
git clone https://github.com/Luccwar/teste-urcamp-VazeaCup.git
```

- Escolha qual dos diretórios do projeto deseja acessar. As instruções abaixo servem para ambos:

    - **PHP Puro**: Este projeto abrange tanto o Back-End quanto o Front-End, desenvolvidos completamente em PHP.
    ```bash
    cd teste-urcamp-VazeaCup/VarzeaCup
    ```

    - **API**: Este projeto consiste apenas no Back-End, baseado no projeto principal mencionado acima.
    ```bash
    cd teste-urcamp-VazeaCup/VarzeaCup-API
    ```

- Instale as dependências do Back-End:

```bash
composer install
npm install
```

### 3. Banco de Dados

- Copie o arquivo `.env.example` para `.env` (se `.env` não existir, crie o arquivo na pasta raiz do projeto) e ajuste as configurações específicas do banco de dados:

O exemplo abaixo está configurado com PostgreSQL. Substitua as configurações de acordo com o seu banco de dados. 

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=VarzeaCUP
DB_USERNAME=postgres
DB_PASSWORD=123456
```

- Após configurar o arquivo `.env`, utilize o comando abaixo para gerar uma chave de criptografia e evitar erros no projeto:

```bash
php artisan key:generate
```

- Execute o comando `migrate` para criar as tabelas no banco de dados:

```bash
php artisan migrate
```

- Por fim, utilize o comando `db:seed` para popular o banco de dados com um usuário administrador pré-configurado. As credenciais são:

    - **Nome**: Admin  
    - **Email**: admin@admin.com  
    - **Senha**: admin1  

```bash
php artisan db:seed --class=DatabaseSeeder
```

## Rodar o Projeto

### 1. Servidor Backend

- Inicie o servidor Laravel:

```bash
php artisan serve
```

O Back-End estará disponível em `http://127.0.0.1:8000` (ou conforme configurado no arquivo `.env`).

### 2. Credenciais de Acesso

O banco de dados já está populado com as seguintes credenciais de login:

- **Email**: admin@admin.com  
- **Senha**: admin1  

### 3. Rotas do Sistema

1. **Página Inicial/Listagem dos Campeonatos**: `http://127.0.0.1:8000`  
2. **Rota de Login**: `http://127.0.0.1:8000/login`  
3. **Rota de Usuários**: `http://127.0.0.1:8000/users` (Acessível apenas se autenticado)  
4. **Rota de Times**: `http://127.0.0.1:8000/teams` (Acessível apenas se autenticado)  
5. **Rota de Partidas**: `http://127.0.0.1:8000/games` (Acessível apenas se autenticado)  
