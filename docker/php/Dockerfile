FROM composer:2.4.2 as composer

##################################

FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y \
            zlib1g-dev \
            libzip-dev \
            wkhtmltopdf \
            fonts-wqy-microhei \
            ttf-wqy-microhei \
            fonts-wqy-zenhei \
            ttf-wqy-zenhei

RUN docker-php-ext-install pdo_mysql zip

RUN pecl install apcu-5.1.17
RUN docker-php-ext-enable apcu

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/src/app

ARG APP_FOLDER

RUN mkdir /.composer && chown 1000 /.composer

COPY apps/back /usr/src/app

RUN composer install && composer clear-cache
RUN composer dump-autoload --optimize --classmap-authoritative --no-dev

RUN mkdir -p /usr/src/app/var/cache
RUN chmod -R a+w /usr/src/app/var/cache

RUN mkdir -p /usr/src/app/var/log
RUN chmod -R a+w /usr/src/app/var/log

RUN PATH=$PATH:/usr/src/apps/vendor/bin:bin


COPY . /usr/src/app

RUN chown -R 1000:1000 /usr/src/app
USER 1000:1000
