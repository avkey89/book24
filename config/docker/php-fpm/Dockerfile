FROM php:7.4-fpm-alpine

RUN apk add --no-cache autoconf g++ make \
    && apk add mysql mysql-client mariadb-client

RUN docker-php-ext-install pdo_mysql

WORKDIR /var/www

ENV COMPOSER_ALLOW_SUPERUSER 1

RUN curl -sL https://getcomposer.org/installer | php -- --install-dir /usr/bin --filename composer