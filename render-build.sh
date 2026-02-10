#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-interaction --optimize-autoloader --no-dev
npm install
npm run build

php artisan migrate --force
