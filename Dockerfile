FROM php:8.4-apache

# Install system dependencies and required libraries
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm

# Install PHP extensions needed for Laravel and PostgreSQL (Supabase)
RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip

# Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# Update Apache document root to point to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Set the working directory
WORKDIR /var/www/html

# Get Composer from the official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the rest of the application files
COPY . .

# Install PHP dependencies (ignoring dev dependencies for production)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Install Node dependencies and build the frontend assets (Tailwind/Vite)
RUN npm install
RUN npm run build

# Fix permissions for Laravel storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Add the startup script
COPY render-start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/render-start.sh

# Use the startup script to launch Apache
CMD ["render-start.sh"]
