FROM php:7.4-apache

RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        curl \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libxml2-dev \
        libonig-dev \
        libpng-dev \
        libzip-dev \
        unzip \
        zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" mysqli pdo pdo_mysql gd zip exif mbstring bcmath xml \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV PHPMYADMIN_VERSION=5.2.1

RUN mkdir -p /usr/share/phpmyadmin /var/lib/phpmyadmin/tmp \
    && curl -fsSL "https://files.phpmyadmin.net/phpMyAdmin/${PHPMYADMIN_VERSION}/phpMyAdmin-${PHPMYADMIN_VERSION}-all-languages.tar.gz" \
      | tar xz --strip-components=1 -C /usr/share/phpmyadmin \
    && chown -R www-data:www-data /var/lib/phpmyadmin

COPY docker/php74-apache/phpmyadmin.conf /etc/apache2/conf-enabled/phpmyadmin.conf
COPY docker/php74-apache/phpmyadmin.config.inc.php /usr/share/phpmyadmin/config.inc.php
COPY docker/php74-apache/umla-laravel.conf /etc/apache2/conf-enabled/umla-laravel.conf

WORKDIR /var/www/html
