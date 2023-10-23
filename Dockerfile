# Utilisez l'image de base PHP avec Apache
FROM php:8.2-apache

# Installez les extensions PDO et PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql

# Copiez votre code source dans le container
COPY ./src /var/www/html
COPY .env /var/www/html/.env