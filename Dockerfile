FROM php:8.2-apache
# Instalamos la extensión necesaria para conectar con MySQL
RUN docker-php-ext-install pdo pdo_mysql