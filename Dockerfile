# Image de base avec Apache et PHP 8.2
FROM php:8.2-apache

# Installation des extensions nécessaires à PostgreSQL
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Activation du module Apache mod_rewrite
RUN a2enmod rewrite

# Configuration par défaut du port utilisé par Render
ENV PORT 80

# Copie du code de l'application dans le répertoire web d'Apache
COPY public/ /var/www/html/
COPY public/font/ /var/www/html/font/

# Autorisations sur les fichiers (recommandé pour éviter les erreurs)
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Exposition du port (utile en local ou pour documentation)
EXPOSE 80