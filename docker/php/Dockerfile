FROM php:8.1-fpm
RUN docker-php-ext-install pdo_mysql
RUN pecl install redis && docker-php-ext-enable redis
WORKDIR /var/www/html