FROM php:8.4-fpm-bookworm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    $PHPIZE_DEPS \
    && docker-php-ext-install -j"$(nproc)" \
        pdo_mysql \
        bcmath \
        pcntl \
        intl \
        zip \
        opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

EXPOSE 9000

CMD ["php-fpm"]