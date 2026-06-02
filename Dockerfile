FROM php:8.3-fpm

# ========================
# SYSTEM DEPENDENCIES
# ========================
RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# ========================
# NODEJS
# ========================
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# ========================
# COMPOSER
# ========================
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# ========================
# COPY PROJECT
# ========================
COPY . .

# ========================
# PHP DEPENDENCIES
# ========================
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

# ========================
# LARAVEL OPTIMIZE
# ========================
RUN php artisan optimize:clear || true
RUN php artisan package:discover || true

# ========================
# FRONTEND BUILD
# ========================
RUN npm install
RUN npm run build

# ========================
# PERMISSIONS
# ========================
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

# ========================
# START (RAILWAY)
# ========================
CMD php artisan serve --host=0.0.0.0 --port=$PORT
