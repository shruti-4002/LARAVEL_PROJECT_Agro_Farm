
FROM php:8.2-cli-alpine


RUN apk add --no-cache \
    autoconf \
    build-base \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    zip \
    unzip \
    git \
    openssl-dev \
    pkgconfig


RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql


RUN pecl install mongodb && docker-php-ext-enable mongodb


WORKDIR /var/www/html
COPY . .


COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install --no-dev --optimize-autoloader


RUN chown -R root:root /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache


RUN php artisan config:cache \
    && php artisan route:cache \
    && php artisan view:cache


CMD php artisan serve --host=0.0.0.0 --port=$PORT