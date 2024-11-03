#!/bin/sh

# Exécuter les migrations
php artisan migrate --force

# Lancer php-fpm
php-fpm
