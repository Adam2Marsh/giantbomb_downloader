#FROM nginx
#
#EXPOSE 80
#
#COPY docker/nginx.conf /etc/nginx/conf.d/giantbomb_downloader.conf
#
#RUN rm /etc/nginx/conf.d/default.conf
#
#RUN mkdir -p /var/www/html
#
#COPY ./ /var/www/html
#
#RUN apt-get update && apt-get install -y \
#        php-fpm


FROM php:7.2-fpm

EXPOSE 80

USER root
RUN apt-get update && apt-get install -y \
        nginx

COPY docker/nginx.conf /etc/nginx/sites-enabled/giantbomb_downloader.conf

COPY docker/zz-docker.conf /usr/local/etc/php-fpm.d/zz-docker.conf

RUN mkdir -p /var/www/html

COPY ./ /var/www/html
RUN cd /var/www && chown -R www-data:www-data html/

CMD php-fpm -D; nginx -g "daemon off;"

