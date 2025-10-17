CompAsia Inventory System

A full-stack inventory management system using Laravel backend, Vue 3 frontend, and Docker for development setup.

Quick Start

Get the project up and running in just a few steps:

Clone the repository
git clone <your-github-repo-url>
cd <project-folder>

Start Docker containers
docker-compose up -d --build

Enter the Laravel app container
docker exec -it laravel_app bash

Install PHP dependencies
composer install

Set up environment file
cp .env-example .env
Update .env with:
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=compasia
DB_USERNAME=root
DB_PASSWORD=root
QUEUE_CONNECTION=sync

Generate Laravel app key
php artisan key:generate

Create symbolic link for storage
php artisan storage:link

Run database migrations
php artisan migrate

Seed initial data
php artisan db:seed --class=ProductMasterListSeeder

How to Use the System

Register a new user

Open the application in your browser.

Click the Register button.

Fill in the pop-up modal with your details and submit.

Login

Use the registered email and password to log in.

Access inventory and system features

Once logged in, you can view inventory, upload Excel files, and perform other system actions.

Tips & Notes

Queue Handling: Currently using QUEUE_CONNECTION=sync, so jobs run immediately for demo/assessment purposes.

File Uploads: Excel files can be uploaded via the inventory module; jobs process them automatically.

Docker Containers:

laravel_app → Laravel backend

db → MySQL database

nginx_server → Nginx frontend

queue_worker → Queue jobs (optional for async)

vue_app → Frontend (Vue 3)

✅ After completing these steps, the system should be fully functional and ready to use.
