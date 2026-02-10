#!/usr/bin/env bash
# exit on error
set -o errexit

echo "Installing composer dependencies..."
composer install --no-interaction --optimize-autoloader --no-dev

echo "Installing npm dependencies..."
npm install

echo "Compiling assets..."
npm run build

echo "Running migrations..."
# O comando migrate --force é necessário em produção
php artisan migrate --force

echo "Seeding admin user..."
# Opcional: Garante que o admin exista no banco da nuvem
php artisan db:seed --class=AdminUserSeeder --force || true

echo "Build finished successfully!"
