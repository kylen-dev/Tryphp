# Simple Apache + PHP image for plain PHP sites
FROM php:8.2-apache

# Install extensions for MySQL/Postgres + common libs
RUN apt-get update && apt-get install -y \
    libzip-dev zlib1g-dev libpng-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mysqli zip gd \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy site into document root
WORKDIR /var/www/html
COPY . /var/www/html

# Ensure correct permissions for Apache
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 755 {} \; \
    && find /var/www/html -type f -exec chmod 644 {} \;

EXPOSE 80
CMD ["apache2-foreground"]
