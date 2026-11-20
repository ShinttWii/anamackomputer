#!/bin/bash

echo "=== aMK: Starting ==="
echo "PORT=$PORT | APP_ENV=$APP_ENV | DB_HOST=$DB_HOST"
echo "Working dir: $(pwd)"
echo "Vendor exists: $([ -d vendor ] && echo YES || echo NO)"

# Storage permissions
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear cache lama
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

# Verifikasi
echo "=== Verify ==="
php artisan tinker --execute="
try {
    \$a = \App\Models\Admin::first();
    echo 'Admin: ' . (\$a ? \$a->username . ' pw_len=' . strlen(\$a->password) : 'NONE') . PHP_EOL;
    echo 'Kerusakan: ' . \App\Models\Kerusakan::count() . PHP_EOL;
    echo 'Session: ' . config('session.driver') . PHP_EOL;
} catch (\Exception \$e) {
    echo 'ERROR: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || echo "Tinker skipped"

# Cache production
php artisan config:cache 2>/dev/null || true
php artisan route:cache  2>/dev/null || true

echo "=== Start server port ${PORT:-8080} ==="
exec php -S 0.0.0.0:${PORT:-8080} -t public
