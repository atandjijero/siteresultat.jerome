# Utilise l'image officielle PHP avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copier les fichiers du projet dans le dossier public du serveur web
COPY public/ /var/www/html/

# Donner les bons droits
RUN chown -R www-data:www-data /var/www/html

# Copier tous les autres fichiers (config.php, includes/, etc.)
COPY config.php /var/www/config.php

# Activer mod_rewrite si besoin
RUN a2enmod rewrite

# Copier un fichier de configuration Apache custom (optionnel)
# COPY apache.conf /etc/apache2/sites-enabled/000-default.conf

# Exposer le port par défaut d’Apache
EXPOSE 80

# Lancer Apache
CMD ["apache2-foreground"]

