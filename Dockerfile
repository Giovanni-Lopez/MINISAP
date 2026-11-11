FROM php:8.4-apache

# Permitir que Composer se ejecute como superusuario
ENV COMPOSER_ALLOW_SUPERUSER=1

# Instalar dependencias del sistema y extensiones de PHP requeridas por Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Resolver conflicto de múltiples MPM en Apache (dejar solo prefork)
RUN a2dismod mpm_event mpm_worker && a2enmod mpm_prefork

# Activar el módulo de reescritura de Apache
RUN a2enmod rewrite

# Instalar Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# Instalar dependencias de Composer
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Permisos para almacenamiento y caché
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apuntar Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Configurar Apache para que escuche en el puerto 8080 que exige Railway
RUN sed -ri -e 's!80!8080!g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080