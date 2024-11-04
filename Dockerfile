FROM php:8.2-apache

# Installez les extensions nécessaires
RUN docker-php-ext-install pdo pdo_mysql
# Copier le fichier de configuration Apache
COPY apache.conf /etc/apache2/sites-available/000-default.conf
# Copiez le contenu de votre application dans le conteneur
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html
# Donner les permissions nécessaires pour Apache
RUN chown -R www-data:www-data /var/www/html
# Donner les permissions nécessaires au dossier storage et bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
# Exposez le port 80
EXPOSE 80

# Activez le module de réécriture
RUN a2enmod rewrite

# Redémarrez Apache pour prendre en compte les changements
CMD ["apache2-foreground"]
