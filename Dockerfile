FROM serversideup/php:8.3-fpm-nginx

WORKDIR /var/www/html

COPY --chown=www-data:www-data . /var/www/html

RUN chmod -R 775 storage bootstrap/cache
