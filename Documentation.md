# Laravel Project (File Management)

Clone the repository and enter...

## Install dependencies via Composer

```bash

## not composer in your computer?
## if you are on linux debian distros
sudo apt-get install composer

## Install dependencies via composer
composer install
```

If you are on window please read the [docs](https://getcomposer.org/) to install composer in your machine.

# Initialize Project

Once install all dependencies, need copy `.env-example` to `.env`.

```bash
copy .env-example .env
```

Enter to `.env` with your favorite editor.

### Install dependencies PHP

For the correct functioning of the project you will need to install the necessary PHP dependencies.

```bash
php 8.2.x
php-fpm 8.2.x
php-gd 8.2.x
php-odbc 8.2.x
php-pgsql 8.2.x
php-sqlite 8.2.x
```

Actually working with php version 8.2.x `x` may change subversion.

### Configure Environment project

Edit `.env` with your database working
if you are work with `mysql` use this configuration:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

if you are with postgres:

```bash
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

Set your credentials your `database`, `username` and `password`.

#### Create database

Enter to mysql or postgres and create the database for the project.

```bash
mysql -u root -p
# enter your username and password
```

Need know your credentials with running the command, `root` is the username and flag -p is for the `password`.

After you enter and create the database, you can run all migrations with command:

```bash
php artisan migrate
```

### Inject Seeders

We need inject two seeders in this order!

```bash
php artisan db:seed --class SeederTablaPermisos
php artisan db:seed --class SuperAdminSeeder
```

## Run the project

```bash
php artisan serve
```

### Credentials to login

```bash
username = admin
password = 12345678
```

You can change the credentials login in this route.
`database/seeders/SuperAdminSeeder.php` make change before you inject seeders command.

# Use Docker

Is configure to image postgres as database and pgadmin4 for the GUI.
Just run `docker-compose.yml`. You can use the reference image either postgres or mysql or any database you work with for laravel.
