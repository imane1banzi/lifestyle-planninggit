# Utiliser une image PHP avec Apache
FROM php:8.2-apache

# Installer les extensions nécessaires pour Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

# Activer le module mod_rewrite d'Apache pour Laravel
RUN a2enmod rewrite

# Copier le fichier de configuration Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tout le projet dans le conteneur
COPY . /var/www/html

# Installer Composer directement dans le conteneur
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Donner les permissions nécessaires pour Apache
RUN chown -R www-data:www-data /var/www/html

# Installer les dépendances Laravel via Composer
RUN composer install --no-dev --optimize-autoloader

# Donner les permissions nécessaires au dossier storage et bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 80 pour Apache
EXPOSE 80

# Commande pour démarrer Apache
CMD ["apache2-foreground"]
