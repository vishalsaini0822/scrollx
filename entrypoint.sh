#!/bin/bash

# Exit immediately on error
set -e

# Ensure Laravel storage is writable
chmod -R 775 storage bootstrap/cache

# Laravel setup
php artisan config:clear
php artisan config:cache
php artisan key:generate
php artisan migrate --force
php artisan storage:link

# Start Laravel server
php artisan serve --host=0.0.0.0 --port=10000
