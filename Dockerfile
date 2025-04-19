# Assuming you're using PHP with Apache or similar
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    unzip \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    git \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy Laravel files
COPY . .

# 🛠 Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Fix permissions (optional but recommended)
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www/storage

# Expose port (should match your render.yaml or Render config)
EXPOSE 10000

# Start Laravel
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=10000"]
