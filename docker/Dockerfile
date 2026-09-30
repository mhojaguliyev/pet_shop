FROM php:8.5-fpm-alpine

RUN apk add --no-cache linux-headers

RUN docker-php-ext-install pdo pdo_mysql sockets

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .
RUN composer install
