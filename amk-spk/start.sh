#!/bin/bash

echo "=== aMK: Starting ==="
echo "PORT=$PORT | APP_ENV=$APP_ENV"
echo "Working dir: $(pwd)"
echo "Vendor exists: $([ -d vendor ] && echo YES || echo NO)"

# ============================================================
# AUTO-MAP Railway MySQL variables ke Laravel DB_* variables
# Railway inject: MYSQLHOST, MYSQLPORT, MYSQLDATABASE,
#                 MYSQLUSER, MYSQLPASSWORD, MYSQL_URL
# ============================================================
if [ -n "$MYSQLHOST" ] && [ -z "$DB_HOST" ]; then
    export DB_CONNECTION=mysql
    export DB_HOST=$MYSQLHOST
    export DB_PORT=${MYSQLPORT:-3306}
    export DB_DATABASE=$MYSQLDATABASE
    export DB_USERNAME=$MYSQLUSER
    export DB_PASSWORD=$MYSQLPASSWORD
    echo "DB auto-mapped from Railway MySQL vars"
    echo "DB_HOST=$DB_HOST | DB_DATABASE=$DB_DATABASE | DB_USERNAME=$DB_USERNAME"
fi

# Juga coba parse MYSQL_URL jika ada (format: mysql://user:pass@host:port/db)
if [ -n "$MYSQL_URL" ] && [ -z "$DB_HOST" ]; then
    export DB_CONNECTION=mysql
    # Ekstrak dari URL menggunakan PHP
    eval $(php -r "
        \$url = parse_url('$MYSQL_URL');
        echo 'export DB_HOST=' . (\$url['host'] ?? '') . PHP_EOL;
        echo 'export DB_PORT=' . (\$url['port'] ?? 3306) . PHP_EOL;
        echo 'export DB_DATABASE=' . ltrim(\$url['path'] ?? '', '/') . PHP_EOL;
        echo 'export DB_USERNAME=' . (\$url['user'] ?? '') . PHP_EOL;
        echo 'export DB_PASSWORD=' . (\$url['pass'] ?? '') . PHP_EOL;
    " 2>/dev/null)
    echo "DB auto-mapped from MYSQL_URL"
    echo "DB_HOST=$DB_HOST | DB_DATABASE=$DB_DATABASE"
fi

echo "DB_CONNECTION=$DB_CONNECTION | DB_HOST=$DB_HOST | DB_DATABASE=$DB_DATABASE"

# ============================================================
# Storage permissions
# ============================================================
mkdir -p storage/app/public storage/framework/cache/data storage/framework/sessions storage/framework/views bootstrap/cache
chmod -R 777 storage bootstrap/cache

# Storage symlink
php artisan storage:link --force 2>/dev/null || true

# Clear cache lama (WAJIB agar pakai env baru)
php artisan config:clear 2>/dev/null || true
php artisan route:clear  2>/dev/null || true
php artisan view:clear   2>/dev/null || true
php artisan cache:clear  2>/dev/null || true

# ============================================================
# Migrate
# ============================================================
echo "=== Migrate ==="
php artisan migrate --force

# ============================================================
# Seed
# ============================================================
echo "=== Seed ==="
php artisan db:seed --force

# ============================================================
# Verifikasi
# ============================================================
echo "=== Verify ==="
php artisan tinker --execute="
try {
    echo 'DB: ' . config('database.default') . PHP_EOL;
    echo 'Admin: ' . \App\Models\Admin::count() . PHP_EOL;
    echo 'Kerusakan: ' . \App\Models\Kerusakan::count() . PHP_EOL;
    echo 'Gejala: ' . \App\Models\Gejala::count() . PHP_EOL;
    echo 'Session: ' . config('session.driver') . PHP_EOL;
} catch (\Exception \$e) {
    echo 'ERROR: ' . \$e->getMessage() . PHP_EOL;
}
" 2>/dev/null || echo "Tinker skipped"

# Cache setelah DB siap
php artisan config:cache 2>/dev/null || true
php artisan route:cache  2>/dev/null || true

echo "=== Start server port ${PORT:-8080} ==="
exec php -S 0.0.0.0:${PORT:-8080} -t public
