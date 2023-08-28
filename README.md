# Pet-Shop API

> ### Pet-Shop API Laravel Application.

----------

# Getting started

### 1. Docker installation

```
git clone git@github.com:mhojaguliyev/pet_shop.git
cd pet_shop
docker-compose up -d --build
docker exec -i app php composer install
docker exec -i app php cp .env.example .env
docker exec -i app php artisan migrate --seed
```
Run larastan
```
 docker exec -i app ./vendor/bin/phpstan analyse
```

Run tests
```
 docker exec -i app php artisan test
```
Run php insights
```
docker exec -i app php artisan insights
```

### 2. Manual Installation

Clone the repository

    git clone git@github.com:mhojaguliyev/pet_shop.git

Switch to the repo folder

    cd pet_shop

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate --seed

Start the local development server

    php artisan serve --port=8888

You can now access the server at http://localhost:8888/api/v1

**Make sure you set the correct database connection information before running the migrations** [Environment variables](#environment-variables)

    php artisan migrate --seed
    php artisan serve --port=8888

# Code overview

## Dependencies

- [tymondesigns/jwt-auth](https://github.com/tymondesigns/jwt-auth) - For authentication using JSON Web Tokens

## Dev Dependencies

- [barryvdh/laravel-ide-helper](https://github.com/barryvdh/laravel-ide-helper)
- [nunomaduro/larastan](https://github.com/nunomaduro/larastan)
- [nunomaduro/phpinsights](https://github.com/nunomaduro/phpinsights)
- [laravel/pint](https://github.com/laravel/pint)

## Folders

- `app` - Contains all the Eloquent models
- `app/Enums` - Contains the Enums
- `app/Filters` - Contains the Eloquent Filter classes
- `app/Http/Controllers` - Contains all the controllers
- `app/Http/Middleware` - Contains the middlewares
- `app/Http/Requests` - Contains all the api form requests
- `app/Http/Resources` - Contains all the api resource files
- `config` - Contains all the application configuration files
- `database/factories` - Contains the model factory for all the models
- `database/migrations` - Contains all the database migrations
- `database/seeds` - Contains the database seeder
- `routes` - Contains all the api routes defined in api_v1.php file
- `tests` - Contains all the application tests
- `tests/Feature` - Contains all the api feature tests
- `tests/Unit` - Contains all the api unit tests

## Environment variables

- `.env` - Environment variables can be set in this file

***Note*** : You can quickly set the database information and other variables in this file and have the application fully working.

----------

## API Documentation

The api documentation can be accessed at [http://localhost:8888](http://localhost:8888).

After seeding the database, 
1. The default admin credentials are:
- Email - admin@example.com
- Password - 123456
2. The default user credentials are:
- Email - user@example.com
- Password - 123456

----------
