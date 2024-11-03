# Utilisez l'image de base de PHP
FROM php:8.2-fpm

# Définir le répertoire de travail
WORKDIR /var/www

# Copier le fichier composer.json et composer.lock
COPY composer.json composer.lock ./

# Installer les dépendances PHP
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd && \
    curl -sSL https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev

# Copier le reste de l'application
COPY . .

# Copier le script d'entrée
COPY entrypoint.sh /usr/local/bin/entrypoint.sh

# Utiliser le script comme point d'entrée
ENTRYPOINT ["entrypoint.sh"]

# Exposer le port
EXPOSE 9000
