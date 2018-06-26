FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libpq-dev

RUN docker-php-ext-install pdo_pgsql