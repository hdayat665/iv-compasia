# CompAsia Inventory System Iv

A full-stack inventory management system using Laravel backend, Vue 3 frontend, and Docker for development setup.

# Quick Start

### 1. Clone the repository
    - git clone <your-github-repo-url>
    - cd <project-folder>

### 2. Start Docker containers
    - docker-compose up -d --build

### 3. Enter the Laravel app container
    - docker exec -it laravel_app bash

### 4. Install PHP dependencies
    - composer install

### 5. Set up environment file
    - cp .env-example .env
    - Update .env with:

       - QUEUE_CONNECTION=sync

### 6. Generate Laravel app key
    - php artisan key:generate

### 7. Create symbolic link for storage
    - php artisan storage:link

### 8. Run database migrations
    - php artisan migrate

### 9. Seed initial data
    - php artisan db:seed --class=ProductMasterListSeeder

# How to Use the System

Register a new user

- Open the application in your browser.

- Click the Register button .

- Fill in the pop-up modal with your details and submit.

Login

- Use the registered email and password to log in.

- Access inventory and system features

- Once logged in, you can view inventory, upload Excel files, and perform other system actions.

## Tips & Notes

- Queue Handling: Using QUEUE_CONNECTION=sync so jobs run immediately for demo/assessment purposes.

- File Uploads: Excel files can be uploaded via the inventory module; jobs process them automatically.

- Docker Containers:

  - laravel_app → Laravel backend

  - db → MySQL database

  - nginx_server → Nginx frontend

  - queue_worker → Queue jobs 

  - vue_app → Frontend (Vue 3)

✅ After completing these steps, the system should be fully functional and ready to use.
