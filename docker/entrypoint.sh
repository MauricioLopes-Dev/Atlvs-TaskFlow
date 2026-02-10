#!/bin/bash

# Rodar migrações e seeders
echo "Running migrations..."
php artisan migrate --force

echo "Seeding admin user..."
php artisan db:seed --class=AdminUserSeeder --force || true

# Iniciar PHP-FPM em background
php-fpm -D

# Iniciar Nginx em foreground
echo "Starting Nginx..."
nginx -g "daemon off;"
