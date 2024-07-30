# Conge App

## Description

This is a vacation leave management application built with Symfony 7.1 and Twig. Users can request, view, and manage their vacation leaves.

## Requirements

- PHP 8.0+
- Composer
- Symfony CLI

## Installation

1. **Clone the repository:**

    ```bash
    git clone https://github.com/JulienMorel76350/m1-DFS-MOREL-JULIEN
    cd '.\03–Architecture MVC–Symfony\'
    cd .\vacation_app\
    ```

2. **Install dependencies:**

    ```bash
    composer install
    ```

3. **Set up the database:**

    ```bash
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```

4. **Run the application:**

    ```bash
    symfony server:start
    ```

## Research Links

Below are the resources I used to complete this project:

- **Setting up Symfony 7.1**: [Symfony Documentation](https://symfony.com/doc/current/setup.html)
- **Adding Tailwind to Symfony**: [Tailwind CSS Guide](https://tailwindcss.com/docs/guides/symfony)
- **Using Maker to Create Controllers, Entities, Auth, etc.**: [Symfony Maker Bundle Documentation](https://symfony.com/bundles/SymfonyMakerBundle/current/index.html)
- **Creating User in Symfony**: [Symfony User Guide](https://symfony.com/doc/current/security.html#the-user)
- **Login Authentication in Symfony**: [Symfony Login Authentication Guide](https://symfony.com/doc/current/security.html#form-login)
