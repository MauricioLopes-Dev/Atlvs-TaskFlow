#!/usr/bin/env bash
# exit on error
set -o errexit

echo "--- Iniciando Build PHP Nativo ---"

# Instalar dependências do PHP
composer install --no-interaction --optimize-autoloader --no-dev

# Run database migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Instalar dependências do Node e compilar assets
npm install
npm run build

# Limpar caches para garantir que as novas configurações sejam lidas
php artisan config:clear
php artisan view:clear
php artisan route:clear

echo "--- Build Finalizado com Sucesso ---"
