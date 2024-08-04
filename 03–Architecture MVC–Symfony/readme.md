# Conge App

## Description

This is a vacation leave management application built with Symfony 7.1 and Twig. Users can request, view, and manage their vacation leaves.
[VIDEO DEMONSTRATION !](https://youtu.be/r1ZzxGJl-kM)

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
    ```bash
    npm i
    ```

### 3. **Set up the database:**

#### macOS with MAMP

1. **Download and Install MAMP:**
   - [Download MAMP](https://www.mamp.info/en/downloads/)

2. **Start MAMP:**
   - Open MAMP and start the servers.

3. **Create a Database:**
   - Open `phpMyAdmin` from MAMP to check if its working.

4. **Configure `.env.local` file:**
   - Create a `.env.local` file at the root of your project and add the following configuration:
   ```bash
     DATABASE_URL="mysql://root:root@127.0.0.1:8889/vacation_bdd?serverVersion=10.11.2"
   ```


#### Windows with XAMPP

1. **Download and Install XAMPP:**
   - [Download XAMPP](https://www.apachefriends.org/index.html)

2. **Start XAMPP:**
   - Open XAMPP Control Panel and start Apache and MySQL.

3. **Create a Database:**
   - Open `phpMyAdmin` from XAMPP to check if its working.

4. **Configure `.env.local` file:**
   - Create a `.env.local` file at the root of your project and add the following configuration:
   ```bash
         DATABASE_URL="mysql://root:@127.0.0.1:3306/vacation_bdd?serverVersion=10.11.2"
   ```
   
5. **Run database migrations:**
    - Becareful to be in the correct file wile :
    ```bash
    php bin/console doctrine:database:create
    php bin/console make:migration
    php bin/console doctrine:migrations:migrate
    ```

6. **Run the application:**
    - Open a terminal:
    ```bash
    npm run dev
    ```
    - Open a second terminal:
    ```bash
    symfony server:start
    ```
    - [Link Open](http://127.0.0.1:8000)

## Research Links

Below are the resources I used to complete this project:

- **Setting up Symfony 7.1**: [Symfony Documentation](https://symfony.com/doc/current/setup.html)
- **Adding Tailwind to Symfony**: [Tailwind CSS Guide](https://tailwindcss.com/docs/guides/symfony)
- **Using Maker to Create Controllers, Entities, Auth, etc.**: [Symfony Maker Bundle Documentation](https://symfony.com/bundles/SymfonyMakerBundle/current/index.html)
- **Creating User in Symfony**: [Symfony User Guide](https://symfony.com/doc/current/security.html#the-user)
- **Login Authentication in Symfony**: [Symfony Login Authentication Guide](https://symfony.com/doc/current/security.html#form-login)
- **Deployment Basics in Symfony**: [Symfony Deployment Basics Guide](https://symfony.com/doc/current/deployment.html)
- **Deployment With upsun in Symfony**: [Upsun Deploy Guide](https://docs.upsun.com/get-started/stacks/symfony.html)

