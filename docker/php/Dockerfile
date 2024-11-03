ARG DOCKER_PHP_VERSION

FROM php:${DOCKER_PHP_VERSION}-fpm-alpine

RUN apk add --update --no-cache icu-libs \
    libintl \
    build-base \
    zlib-dev \
    cyrus-sasl-dev \
    libgsasl-dev \
    oniguruma-dev \
    procps \
    imagemagick \
    patch \
    bash \
    htop \
    acl \
    apk-cron \
    augeas-dev \
    autoconf \
    curl \
    ca-certificates \
    dialog \
    freetype-dev \
    gomplate \
    git \
    gcc \
    gettext-dev \
    icu-dev \
    libcurl \
    libffi-dev \
    libgcrypt-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libmcrypt-dev \
    libressl-dev \
    libxslt-dev \
    libzip-dev \
    linux-headers \
    libxml2-dev \
    ldb-dev \
    make \
    musl-dev \
    mysql-client \
    openssh-client \
    pcre-dev \
    ssmtp \
    sqlite-dev \
    supervisor \
    su-exec \
    wget \
    nodejs \
    npm

#  Install php extensions
RUN php -m && \
    docker-php-ext-configure intl && \
    docker-php-ext-configure pcntl && \
    docker-php-ext-install exif \
    mysqli \
    opcache \
    xsl \
    bcmath \
    gd \
    gettext \
    intl \
    opcache \
    pcntl \
    soap \
    zip \
    calendar \
    pdo_mysql && \
    pecl install redis && \
    docker-php-ext-enable redis && \
    apk add --update --no-cache --virtual .docker-php-mongodb-dependencies \
    heimdal-dev && \
    pecl install mongodb && \
    docker-php-ext-enable mongodb && \
    apk del .docker-php-mongodb-dependencies && \
    apk add --update --no-cache \
    libpq

# Enable Xdebug
ARG DOCKER_PHP_XDEBUG_VERSION
RUN pecl install xdebug-${DOCKER_PHP_XDEBUG_VERSION} && \
    docker-php-ext-enable xdebug

# Конфигурируем Xdebug
RUN echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_log=/var/log/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.discover_client_host" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Clean
RUN rm -rf /var/cache/apk/* && docker-php-source delete

USER root

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer

#  Install php extensions
RUN docker-php-ext-install sockets

WORKDIR /var/www/readys