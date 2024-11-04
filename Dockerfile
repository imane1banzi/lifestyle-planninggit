# Utiliser une image officielle de PHP 8.2 avec Apache
FROM php:8.2-apache

# Mettre à jour les packages et installer les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_mysql

# Installer Composer (version 2.7.9)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.7.9

# Copier le fichier de configuration Apache pour activer la réécriture
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Copier le contenu de votre application dans le conteneur
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Donner les permissions nécessaires pour Apache
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 80 pour Apache
EXPOSE 80

# Activer le module de réécriture Apache
RUN a2enmod rewrite

# Installer les dépendances du projet avec Composer
RUN composer install --no-dev --optimize-autoloader

# Commande pour démarrer Apache en mode frontal
CMD ["apache2-foreground"]
