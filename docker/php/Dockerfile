FROM php:8.2-fpm

# Install dockerize so we can wait for containers to be ready
ENV DOCKERIZE_VERSION 0.6.1

RUN curl -s -f -L -o /tmp/dockerize.tar.gz https://github.com/jwilder/dockerize/releases/download/v$DOCKERIZE_VERSION/dockerize-linux-amd64-v$DOCKERIZE_VERSION.tar.gz \
    && tar -C /usr/local/bin -xzvf /tmp/dockerize.tar.gz \
    && rm /tmp/dockerize.tar.gz

# Install Composer
ENV COMPOSER_VERSION 2.7.8

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=$COMPOSER_VERSION

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        libz-dev \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        libssl-dev \
        libzip-dev \
        libc-client-dev \
        libkrb5-dev \
        unzip \
        zip \
        default-mysql-client \
        nano \
        git \
    && apt-get clean \
    && pecl install redis \
    && docker-php-ext-configure gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-configure calendar \
    && docker-php-ext-configure imap --with-kerberos --with-imap-ssl \
    && docker-php-ext-install \
        gd \
        exif \
        opcache \
        pdo_mysql \
        pdo_pgsql \
        pgsql \
        pcntl \
        zip \
        calendar \
        imap \
    && rm -rf /var/lib/apt/lists/*;

COPY ./docker/php/laravel.ini /usr/local/etc/php/conf.d/laravel.ini

WORKDIR /usr/src/app


RUN mkdir -p bootstrap/cache
RUN mkdir -p storage/logs
RUN mkdir -p storage/framework/sessions
RUN mkdir -p storage/framework/views

RUN chmod -R 777 bootstrap/cache storage

# RUN chown -R www-data:www-data .

