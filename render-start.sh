#!/bin/bash

# Render assigns a dynamic port via the PORT environment variable.
# We need to tell Apache to listen on this port instead of the default 80.
echo "ServerName localhost" >> /etc/apache2/apache2.conf
sed -i "s/Listen 80/Listen ${PORT:-80}/g" /etc/apache2/ports.conf
sed -i "s/:80/:${PORT:-80}/g" /etc/apache2/sites-available/000-default.conf

# Cache configuration for optimal production performance
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions on cached files so Apache can read/write them
chown -R www-data:www-data bootstrap/cache storage

# Start Apache in the foreground
apache2-foreground
