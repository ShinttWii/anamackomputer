#!/bin/bash

echo "=== aMK: Starting ==="
echo "PORT=$PORT | APP_ENV=$APP_ENV | DB_HOST=$DB_HOST | DB_DATABASE=$DB_DATABASE"

# Storage permissions
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear semua cache agar tidak pakai cache lama
php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true
php artisan cache:clear  2>/dev/null || true

# Migrate
echo "=== Migrate ==="
php artisan migrate --force

# Seed
echo "=== Seed ==="
php artisan db:seed --force

# Verifikasi admin
echo "=== Verify ==="
php artisan tinker --execute="
try {
    \$a = \App\Models\Admin::first();
    echo 'Admin: ' . (\$a ? \$a->username . ' | ' . \$a->email : 'NONE') . PHP_EOL;
    echo 'Kerusakan: ' . \App\Models\Kerusakan::count() . PHP_EOL;
    echo 'Gejala: '    . \App\Models\Gejala::count()    . PHP_EOL;
} catch (\Exception \$e) {
    echo 'Verify error: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || echo "Tinker verify skipped"

# Cache setelah semua siap
php artisan config:cache 2>/dev/null || true
php artisan route:cache  2>/dev/null || true

echo "=== Start server on port ${PORT:-8080} ==="
exec php -S 0.0.0.0:${PORT:-8080} -t public
