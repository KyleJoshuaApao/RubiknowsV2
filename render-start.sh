#!/bin/bash

# Render assigns a dynamic port via the PORT environment variable.
# We need to tell Apache to listen on this port instead of the default 80.
echo "ServerName localhost" >> /etc/apache2/apache2.conf
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf

# Prepare the effective Laravel storage path before caching configuration.
# Some deployments set APP_STORAGE; Render still needs those directories writable.
LARAVEL_STORAGE="${APP_STORAGE:-/var/www/html/storage}"
PRIVATE_STORAGE_PATH="${PRIVATE_STORAGE_PATH:-/tmp/rubiknows-private}"
export PRIVATE_STORAGE_PATH
mkdir -p "$LARAVEL_STORAGE/app/public" "$LARAVEL_STORAGE/app/private" "$LARAVEL_STORAGE/framework/cache" "$LARAVEL_STORAGE/framework/sessions" "$LARAVEL_STORAGE/framework/views" "$LARAVEL_STORAGE/logs" "$PRIVATE_STORAGE_PATH"
chown -R www-data:www-data "$LARAVEL_STORAGE" "$PRIVATE_STORAGE_PATH" bootstrap/cache
chmod -R 775 "$LARAVEL_STORAGE" "$PRIVATE_STORAGE_PATH" bootstrap/cache

php artisan storage:link --force

# Cache configuration for optimal production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions on cached files so Apache can read/write them
php artisan storage:link --force
chown -R www-data:www-data bootstrap/cache storage
chmod -R 775 bootstrap/cache storage

# Process queued notifications without blocking public form submissions.
php artisan queue:work --no-interaction --sleep=1 --tries=1 --timeout=30 &

# Start Apache in the foreground
apache2-foreground
