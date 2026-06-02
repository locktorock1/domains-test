FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    nginx \
    git curl zip unzip \
    libzip-dev libpng-dev libonig-dev libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY composer.json composer.lock ./
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

COPY package.json package-lock.json ./
RUN npm install

COPY . .

RUN npm run build

RUN chmod -R 775 storage bootstrap/cache

# nginx
RUN rm -f /etc/nginx/conf.d/default.conf
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf

EXPOSE 80

CMD sh -c "php-fpm -D && nginx -g 'daemon off;'"
