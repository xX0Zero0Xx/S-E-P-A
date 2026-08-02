# Stage 1: Compilación de dependencias
FROM composer:2 AS vendor
WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist

# Stage 2: Imagen final ligera
FROM php:8.2-fpm-alpine
WORKDIR /var/www/html

# Instalar extensiones necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Copiar proyecto y dependencias
COPY . .
COPY --from=vendor /app/vendor ./vendor

RUN php artisan dump-autoload --optimize

# Configurar usuario no-root
RUN chown -R www-data:www-data /var/www/html
USER www-data

EXPOSE 9000
CMD ["php-fpm"]