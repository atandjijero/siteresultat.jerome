FROM php:8.2-apache

# Installe l'extension PDO pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Active le module rewrite si besoin
RUN a2enmod rewrite

# Copie tes fichiers du dossier public
COPY public/ /var/www/html/

# Donne les droits (facultatif)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

EXPOSE 80