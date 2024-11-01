FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy application
COPY . /pollution-monitor-app

# Set permissions
RUN chown -R www-data:www-data /pollution-monitor-app

WORKDIR /pollution-monitor-app

RUN chmod -R 777 /pollution-monitor-app/storage/

# Install dependencies
RUN composer install --optimize-autoloader --no-dev

EXPOSE 9000
CMD ["php-fpm"]
