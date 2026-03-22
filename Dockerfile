FROM php:8.2-apache

# Instalamos las librerías del sistema necesarias para PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copiamos tus archivos al servidor
COPY . /var/www/html/

EXPOSE 80
