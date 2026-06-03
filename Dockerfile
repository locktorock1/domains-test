FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git curl zip unzip \
    libzip-dev libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY . .

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer install --no-interaction --prefer-dist --optimize-autoloader

RUN npm install
RUN npm run build

RUN chmod -R 775 storage bootstrap/cache

EXPOSE 9000

CMD php artisan serve --host=0.0.0.0 --port=8080
