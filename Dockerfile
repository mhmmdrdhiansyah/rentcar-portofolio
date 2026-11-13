# Let's Ride Belitung — PHP-FPM (Alpine) app image
FROM php:8.3-fpm-alpine

RUN apk add --no-cache icu-dev libpng-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo_mysql mbstring intl gd zip

# Composer from official image
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install dependencies first for layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-interaction

COPY . .
RUN composer dump-autoload --optimize \
    && php artisan config:cache || true

RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data

EXPOSE 9000
CMD ["php-fpm"]
