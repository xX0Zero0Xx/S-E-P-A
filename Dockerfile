# Dockerfile para el contenedor SEPA_web (Apache2 + PHP)
FROM php:8.4-apache

# Instalación de extensiones necesarias para Laravel y MySQL
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libpq-dev zip unzip git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql pdo_mysql

# Habilitar mod_rewrite de Apache para Laravel
RUN a2enmod rewrite

# Cambiar DocumentRoot de Apache a /public para que apunte al directorio correcto de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html

# Crear directorios de almacenamiento necesarios para Laravel y asignar permisos a www-data (Apache)
RUN mkdir -p storage/framework/views storage/framework/cache storage/framework/sessions storage/logs \
    && chmod -R 775 storage \
    && chown -R www-data:www-data storage