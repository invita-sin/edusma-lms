FROM php:8.3-fpm

ARG USER=edusma
ARG UID=1000

RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libicu-dev \
    supervisor \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN chown -R $USER:$USER /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

COPY deploy/nginx.conf /etc/nginx/sites-available/default
COPY deploy/supervisor.conf /etc/supervisor/conf.d/edusma.conf

EXPOSE 80

CMD ["sh", "-c", "php artisan migrate --force && php artisan config:cache && php artisan route:cache && php artisan view:cache && supervisord -c /etc/supervisor/supervisord.conf && nginx -g 'daemon off;'"]
