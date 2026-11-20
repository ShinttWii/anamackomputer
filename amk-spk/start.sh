#!/bin/bash
set -e

echo "=== aMK: Starting deployment ==="
echo "PORT: $PORT"
echo "APP_ENV: $APP_ENV"
echo "DB_HOST: $DB_HOST"

# Pastikan storage writable
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Storage link
php artisan storage:link --force || echo "Storage link skipped"

# Clear semua cache dulu (WAJIB sebelum config:cache agar pakai env Railway)
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# Migrate database
echo "=== Running migrations ==="
php artisan migrate --force

# Seed data (truncate + insert ulang)
echo "=== Running seeders ==="
php artisan db:seed --force

echo "=== Seeder done, cek data admin ==="
php artisan tinker --execute="echo 'Admin count: ' . \App\Models\Admin::count();"

# Cache setelah migrate & seed selesai
php artisan config:cache
php artisan route:cache

echo "=== Starting PHP server on port ${PORT:-8080} ==="
php -S 0.0.0.0:${PORT:-8080} -t public
