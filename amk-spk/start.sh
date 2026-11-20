#!/bin/bash
set -e

echo "=== aMK: Starting deployment ==="

# Pastikan storage writable
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Storage link
php artisan storage:link --force || echo "Storage link skipped"

# Clear semua cache (agar pakai env vars Railway yang baru)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Optimize untuk production
php artisan config:cache
php artisan route:cache

# Migrate database
echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Starting PHP server on port $PORT ==="
php -S 0.0.0.0:${PORT:-8080} -t public
