FROM php:7.2-fpm

RUN apt-get update && apt-get install -y libpq-dev supervisor

RUN docker-php-ext-install pdo pdo_pgsql pgsql

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]