# Use official PHP image with Apache
FROM php:8.4-apache

# Set working directory
WORKDIR /var/www/html/PostPilot

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd intl pdo pdo_pgsql pgsql bcmath zip opcache \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set Apache to use Laravel's public/ folder
RUN sed -i 's#/var/www/html#/var/www/html/PostPilot/public#g' /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies via Composer
RUN composer install --no-dev --optimize-autoloader --working-dir=/var/www/html/PostPilot

# Create and set permissions for storage and bootstrap/cache
RUN mkdir -p /var/www/html/PostPilot/storage /var/www/html/PostPilot/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/PostPilot/storage /var/www/html/PostPilot/bootstrap/cache

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]