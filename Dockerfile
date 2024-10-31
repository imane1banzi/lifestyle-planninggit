# Utilise une image PHP officielle
FROM php:8.2-apache

# Installe les dépendances système requises
RUN apt-get update && apt-get install -y \
    curl \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Installe Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer

# Définit le répertoire de travail
WORKDIR /app

# Copie les fichiers de l'application dans le conteneur
COPY . .

# Installe les dépendances PHP
RUN composer install --no-dev

# Expose le port 80
EXPOSE 80
