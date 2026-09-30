# Pet-Shop API

> ### Pet-Shop API Laravel Application.

----------

# Getting started

Requirements: PHP 8.5, Composer, Node.js and MySQL 8.4 (or Docker).

### 1. Docker installation

```
git clone git@github.com:mhojaguliyev/pet_shop.git
cd pet_shop
cp .env.example .env
docker compose up -d --build
docker compose exec main composer install
docker compose exec main php artisan key:generate
npm install && npm run build
```

Migrate data with seeding

```
docker compose exec main php artisan migrate --seed
```

Seeding categories and products with dummy data

```
docker compose exec main php artisan db:seed --class=CategoryProductSeeder
```

Run tests

```
docker compose exec main composer test
```

Run static analysis and code style checks (Rector, Pint, Larastan)

```
docker compose exec main composer lint
```

Apply automated refactoring and code style fixes (Rector, Pint)

```
docker compose exec main composer refactor
```

Run PHP Insights

```
docker compose exec main php artisan insights
```

### 2. Manual Installation

Clone the repository and switch to the repo folder

    git clone git@github.com:mhojaguliyev/pet_shop.git
    cd pet_shop

Set the database connection in `.env` (see [Environment variables](#environment-variables)), then install dependencies, generate the application key, run the migrations and build the frontend assets

    composer setup

Seed the database

    php artisan db:seed

Start the development processes (server, queue, logs and Vite)

    composer dev

You can now access the server at http://localhost:8000/api/v1

# Code overview

## Dependencies

- [laravel/sanctum](https://github.com/laravel/sanctum) - For API token authentication

## Dev Dependencies

- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- [driftingly/rector-laravel](https://github.com/driftingly/rector-laravel) - Keeps the code up to date with the latest Laravel and PHP versions
- [larastan/larastan](https://github.com/larastan/larastan)
- [laravel/pail](https://github.com/laravel/pail)
- [laravel/pao](https://github.com/laravel/pao)
- [laravel/pint](https://github.com/laravel/pint)
- [nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)

## Folders

- `app/Enums` - Contains the Enums
- `app/Events` - Contains the events
- `app/Filters` - Contains the Eloquent Filter classes
- `app/Http/Controllers` - Contains all the controllers
- `app/Http/Middleware` - Contains the middlewares
- `app/Http/Requests` - Contains all the api form requests
- `app/Http/Resources` - Contains all the api resource files
- `app/Listeners` - Contains the event listeners
- `app/Models` - Contains all the Eloquent models
- `bootstrap/app.php` - Configures routing, middleware and exception handling
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeders` - Contains the database seeders
- `routes` - Contains the routes; api routes are defined in `routes/api/v1.php`
- `tests/Feature` - Contains all the api feature tests
- `tests/Unit` - Contains all the api unit tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

## Authentication

Log in via `POST /api/v1/user/login` to receive an API token, then send it with every authenticated request:

    Authorization: Bearer <token>

Tokens expire after `SANCTUM_TOKEN_EXPIRATION` minutes (default 120) and are revoked on logout. Expired tokens are pruned daily by the scheduler, so make sure `php artisan schedule:run` runs every minute in production.

## API Documentation

The api documentation can be accessed at the application root, e.g. [http://localhost:8888](http://localhost:8888) with Docker (`APP_PORT`).

After seeding the database,
1. The default admin credentials are:
- Email - admin@example.com
- Password - admin
2. The default user credentials are:
- Email - user@example.com
- Password - user

----------
