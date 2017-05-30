FROM php:7-cli

# Maintainer
LABEL maintainer "krzysztof@kardasz.eu"

# Update system and install required packages
ENV DEBIAN_FRONTEND noninteractive

# Common tools
RUN \
    apt-get -y update && \
    apt-get -y install curl git telnet vim autoconf file g++ gcc libc-dev make pkg-config re2c wget

# PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libzip-dev \
        libevent-dev \
        libicu-dev \
        libmcrypt-dev \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        libwebp-dev \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ \
        --with-jpeg-dir=/usr/include/ \
        --with-png-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install intl \
    && docker-php-ext-install mcrypt \
    && docker-php-ext-install iconv \
    && docker-php-ext-install opcache \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install sockets \
    && rm -rf /var/lib/apt/lists/*

# PECL extensions
RUN \
    pecl install event && \
    docker-php-ext-enable event

# PHP Tools
RUN \
    curl -sS https://getcomposer.org/installer | /usr/local/bin/php -- --install-dir=/usr/local/bin --filename=composer

