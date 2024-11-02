# Étape 1 : Image de base PHP
FROM php:8.2-fpm AS base

# Installer les dépendances système requises
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# Étape 2 : Installer Composer
FROM composer:latest AS composer

# Étape 3 : Image finale
FROM base

# Copier l'exécutable Composer depuis l'image Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail
WORKDIR /app

# Copier le fichier composer.json et composer.lock
COPY composer.json composer.lock ./

# Installer les dépendances
RUN composer install --no-dev

# Copier le reste de votre application
COPY . .

# Exposer le port
EXPOSE 9000

# Commande pour démarrer le serveur PHP
CMD ["php-fpm"]
