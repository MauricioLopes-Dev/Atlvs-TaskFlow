#!/bin/bash

# Garantir permissões em tempo de execução
echo "Setting permissions..."
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

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
