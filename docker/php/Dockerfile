FROM php:7.4-fpm
COPY php.ini /usr/local/etc/php/

RUN apt-get update \
    && apt-get install -y zlib1g-dev libzip-dev unzip \
    && docker-php-ext-install pdo pdo_mysql zip

RUN pecl install xdebug \
  && docker-php-ext-enable xdebug

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
