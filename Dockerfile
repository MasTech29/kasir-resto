FROM php:8.0-cli

WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /app

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN php artisan config:clear

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT
