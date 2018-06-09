FROM php:7.2-fpm

RUN docker-php-ext-install pdo_mysql

USER root

RUN apt-get update && apt-get install -y supervisor

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c",  "/etc/supervisord.conf"]