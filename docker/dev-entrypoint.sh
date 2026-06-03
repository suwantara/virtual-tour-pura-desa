#!/usr/bin/env bash
set -euo pipefail

echo "▶ Virtual Tour — dev entrypoint"

# ── Install composer dependencies ──────────────────────────────────────────
if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "  → Installing composer dependencies..."
    composer install --no-interaction
else
    echo "  → Composer dependencies already installed."
fi

# ── Ensure storage directories exist ───────────────────────────────────────
mkdir -p /var/www/html/storage/framework/{views,cache,sessions,testing}
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/storage/app/public
mkdir -p /var/www/html/bootstrap/cache
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# ── Wait for database ──────────────────────────────────────────────────────
echo "  → Waiting for database..."
until php artisan db:show --no-interaction > /dev/null 2>&1; do
    echo "     database not ready, retrying in 3s..."
    sleep 3
done
echo "  → Database ready."

# ── Run migrations ─────────────────────────────────────────────────────────
echo "  → Running migrations..."
php artisan migrate --force --no-interaction

# ── Clear dev caches ───────────────────────────────────────────────────────
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

# ── Storage link (idempotent) ──────────────────────────────────────────────
php artisan storage:link --quiet 2>/dev/null || true

# ── Start the process ──────────────────────────────────────────────────────
echo "  → Starting: $*"
exec "$@"
