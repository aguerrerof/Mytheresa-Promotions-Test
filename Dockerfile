FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    unzip \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    libzip-dev \
    libsqlite3-dev \
    pkg-config \
    libssl-dev \
    zlib1g-dev \
    && docker-php-ext-install pdo_sqlite bcmath zip pcntl

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-autoloader

COPY . .

RUN composer dump-autoload && php artisan config:clear

EXPOSE 8000

CMD sh -c "if [ ! -f database/database.sqlite ]; then mkdir -p database && touch database/database.sqlite; fi && php artisan migrate --force && php artisan serve --host=127.0.0.1 --port=8000"
