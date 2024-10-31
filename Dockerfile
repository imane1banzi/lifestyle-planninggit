# Utilise une image PHP officielle
FROM php:8.2-apache

# Installe les dépendances système requises
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définit le répertoire de travail
WORKDIR /app

# Copie les fichiers de l'application dans le conteneur
COPY . .

# Installe les dépendances PHP
RUN composer install --no-dev

# Expose le port 80
EXPOSE 80
