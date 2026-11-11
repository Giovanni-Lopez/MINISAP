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

# Activar el módulo de reescritura de Apache (vital para las rutas de Laravel)
RUN a2enmod rewrite

# Instalar Composer oficial
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configurar el directorio de trabajo
WORKDIR /var/www/html

# Copiar los archivos del proyecto al contenedor
COPY . .

# Instalar dependencias de Composer sin conflictos de plataforma
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Asegurar permisos correctos para las carpetas de almacenamiento y caché
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Apuntar Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# Cambiar el puerto por defecto de Apache a 8080 para que Railway lo acepte sin problemas
RUN sed -ri -e 's!80!8080!g' /etc/apache2/ports.conf /etc/apache2/sites-available/000-default.conf

EXPOSE 8080