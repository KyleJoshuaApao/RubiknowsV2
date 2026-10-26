# ---- Stage 1: PHP runtime + Composer dependencies ----------------------------
FROM php:8.4-apache AS app

# System libraries for the PHP extensions below (PostgreSQL/Supabase, intl, gd, zip)
RUN apt-get update && apt-get install -y --no-install-recommends \
        libpq-dev \
        libicu-dev \
        libpng-dev \
        libzip-dev \
        unzip \
        git \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql gd zip intl

# Align PHP's multipart limits with the largest validated admin/public uploads.
COPY docker/php/uploads.ini /usr/local/etc/php/conf.d/uploads.ini

RUN a2enmod rewrite headers deflate expires

# Serve Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

WORKDIR /var/www/html

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .
RUN composer install --no-interaction --optimize-autoloader --no-dev

# ---- Stage 2: build front-end assets (Node is not shipped in the final image) --
FROM node:24-slim AS assets

WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci

COPY . .
# Tailwind scans vendor pagination views, so bring in the Composer packages.
COPY --from=app /var/www/html/vendor ./vendor
RUN npm run build

# ---- Stage 3: final image ----------------------------------------------------
FROM app

COPY --from=assets /app/public/build ./public/build

RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY render-start.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/render-start.sh

CMD ["render-start.sh"]
