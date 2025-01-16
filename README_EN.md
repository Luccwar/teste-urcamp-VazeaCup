<a href="https://github.com/Luccwar/teste-urcamp-VazeaCup/blob/main/README_EN.md"><img alt="Change Language to English" src="https://img.shields.io/badge/lang-en-darkred"></a> <a href="https://github.com/Luccwar/teste-urcamp-VazeaCup/blob/main/README.md"><img alt="Mudar Língua para o Português Brasileiro" src="https://img.shields.io/badge/lang-pt--br-darkgreen" ></a>

# Varzea Cup

Hello, this project was developed as part of an evaluation for Urcamp. I would like to highlight that the pure PHP project is complete; however, due to complications during development, it was only possible to create the API, without a front-end to consume the data.

## Tables of Content

- [Features](#features)
- [Installation](#installation)
- [Run the Project](#run-the-project)

## Features

In the current project, you can create, edit, delete, and list records of users, teams, and games within a championship. The championship information is dynamically calculated on its respective relevant pages.

It is important to note that the user must be logged in to access the routes for users, teams, and games. If the user is not authenticated, they will only be able to view the homepage and the login page.

All creation and editing forms for records in the project within the VarzeaCup folder include validations to ensure data integrity.

## Installation

### 1. Prerequisites

Ensure that the following requirements are installed:

- PHP 8.3 e Laravel 11 - The project was developed using these framework versions. It may work with earlier versions, but this is not guaranteed;
- Composer in its most updated version;
- PostgreSQL 16 Relational Database and pgAdmin4;
- NodeJS in its most updated version.

### 2. Steps to Install the Project

- Clone the Repository:

```bash
git clone https://github.com/Luccwar/teste-urcamp-VazeaCup.git
```

- Choose which directory of the project you want to access. The instructions below apply to both:

    - **PHP Puro**: This project covers both the Back-End and the Front-End, fully developed in PHP.
    ```bash
    cd teste-urcamp-VazeaCup/VarzeaCup
    ```

    - **API**: This project consists only of the Back-End, based on the main project mentioned above.
    ```bash
    cd teste-urcamp-VazeaCup/VarzeaCup-API
    ```

- Install Back-End Dependencies:

```bash
composer install
npm install
```

### 3. Database Setup

- Copy the `.env.example` file to `.env` (if `.env` doesn't exist, create it in the root directory of the project) and adjust the database-specific configurations:

The example below is configured with PostgreSQL. Replace the settings according to your database. 

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=VarzeaCUP
DB_USERNAME=postgres
DB_PASSWORD=123456
```

- After configuring the `.env`, file, use the command below to generate an encryption key to prevent errors in the project:

```bash
php artisan key:generate
```

- Run `migrate` command to create the necessary tables in the database:

```bash
php artisan migrate
```

- Finally, use the `db:seed` command to populate the database with a pre-configured administrator user. The credentials are:

    - **Name**: Admin  
    - **Email**: admin@admin.com  
    - **Password**: admin1  

```bash
php artisan db:seed --class=DatabaseSeeder
```

## Running the Project

### 1. Backend Server

- Start the Laravel server:

```bash
php artisan serve
```

The Back-End will be available at `http://127.0.0.1:8000` (or as configured in the `.env` file).

### 2. Access Credentials

The database is already populated with the following login credentials:

- **Email**: admin@admin.com  
- **Password**: admin1  

### 3. System Routes

1. **Home Page/List of Championships**: `http://127.0.0.1:8000`  
2. **Login Route**: `http://127.0.0.1:8000/login`  
3. **Users Route**: `http://127.0.0.1:8000/users` (Accessible only if authenticated)  
4. **Teams Route**: `http://127.0.0.1:8000/teams` (Accessible only if authenticated)  
5. **Games Route**: `http://127.0.0.1:8000/games` (Accessible only if authenticated)  
