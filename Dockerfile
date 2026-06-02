FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git curl zip unzip \
    libzip-dev libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

# =========================
# 1. INSTALL PHP DEPENDENCIES
# =========================
COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install \
    --no-interaction \
    --prefer-dist \
    --no-scripts

# =========================
# 2. COPY FULL PROJECT
# =========================
COPY . .

# =========================
# 3. RUN LARAVEL SCRIPTS
# =========================
RUN php artisan package:discover || true

# =========================
# 4. FRONTEND BUILD
# =========================
COPY package.json package-lock.json ./
RUN npm install
RUN npm run build

# =========================
# 5. PERMISSIONS
# =========================
RUN chmod -R 775 storage bootstrap/cache

# =========================
# 6. NGINX
# =========================
RUN rm -f /etc/nginx/conf.d/default.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD sh -c "php-fpm -D && nginx -g 'daemon off;'"
