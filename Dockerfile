# Use the official PHP image with FPM
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libcurl4-openssl-dev \
    libssl-dev \
    mariadb-client \
    nginx \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application code
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

# Copy nginx config
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Expose the port
EXPOSE 10000

# At runtime, run migrations then spin up PHP's built‑in server on the Render $PORT
CMD php artisan migrate --force \
  && php -S 0.0.0.0:${PORT} -t public