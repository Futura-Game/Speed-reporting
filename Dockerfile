FROM php:8.2-apache

# Update et installation des dépendances
RUN apt-get update && apt-get upgrade -y && apt-get clean

# Active le mode rewrite
RUN a2enmod rewrite

# Extensions PHP
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Config Apache (on écrase la config par défaut)
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# On donne les droits au dossier (utile pour les fichiers générés)
RUN chown -R www-data:www-data /var/www/html