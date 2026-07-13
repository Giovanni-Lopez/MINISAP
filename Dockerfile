FROM php:8.4-cli

# System deps and PHP extensions required by Laravel
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev libonig-dev \
  && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring zip \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --optimize-autoloader --no-scripts --no-interaction --no-dev

# Laravel serves on $PORT; bind to 0.0.0.0
CMD php artisan serve --host=0.0.0.0 --port=${PORT:-8080}
