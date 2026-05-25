FROM php:8.2-fpm


RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip unzip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install gd pdo pdo_mysql


COPY . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

CMD php artisan serve --host=0.0.0.0 --port=$PORT