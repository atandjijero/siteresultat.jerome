FROM php:8.2-apache

# Installe les extensions nécessaires pour PostgreSQL
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Active le module mod_rewrite (utile avec .htaccess)
RUN a2enmod rewrite

# Définis la variable d'environnement PORT pour Render
ENV PORT=80

# Copie tes fichiers dans le dossier web d'Apache
COPY public/ /var/www/html/

# Fixe les permissions (facultatif mais recommandé)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose le port 80 (Apache)
EXPOSE 80