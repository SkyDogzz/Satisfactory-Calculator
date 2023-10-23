# Utilisez l'image de base PHP avec Apache
FROM php:8.2-apache

# Mettez à jour la liste des paquets et installez les dépendances nécessaires
RUN apt-get update && \
    apt-get install -y libzip-dev unzip && \
    docker-php-ext-install pdo pdo_mysql zip

# Copiez votre code source dans le container
COPY ./src /var/www/html
COPY .env /var/www/html/.env

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Installez les dépendances de Composer
CMD bash -c "composer install --working-dir=/var/www/html && apache2-foreground"
