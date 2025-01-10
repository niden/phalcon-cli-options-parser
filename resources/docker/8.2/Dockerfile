FROM composer:2.8.4 AS composer
FROM php:8.2-fpm

COPY ./extra.ini /usr/local/etc/php/conf.d/

# User/Group globals
ENV MY_USER="phalcon" \
    MY_GROUP="phalcon" \
    MY_UID="1000" \
    MY_GID="1000" \
    PHP_VERSION="8.2"

# User and Group
RUN set -eux; \
    groupadd -g ${MY_GID} -r ${MY_GROUP}; \
    useradd -u ${MY_UID} -m -s /bin/bash -g ${MY_GROUP} ${MY_USER}; \
    apt update -y; \
    apt install -y --no-install-recommends \
        apt-utils \
        gettext \
        git \
        libzip-dev \
        nano \
        sudo \
        wget \
        zip; \
    pecl install xdebug; \
    docker-php-ext-install zip; \
    docker-php-ext-enable xdebug; \
    rm -rf /var/lib/apt/lists/* /var/cache/apt/archives/*

# Composer
COPY --from=composer /usr/bin/composer /usr/local/bin/composer

# Bash script with helper aliases
COPY ./.bashrc /root/.bashrc
COPY ./.bashrc /home/phalcon/.bashrc
