FROM php:8.2-apache

# Copie les fichiers dans le répertoire de l'image
COPY public/ /var/www/html/

# Active le module rewrite d'Apache (souvent utile avec PHP)
RUN a2enmod rewrite

# Copie un fichier de configuration personnalisé si nécessaire
# COPY config.php /var/www/html/config.php  # Déjà dans le dossier public, donc normalement pas nécessaire

# Donne les bons droits (facultatif selon ton besoin)
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Expose le port 80 pour accéder à l'appli
EXPOSE 80