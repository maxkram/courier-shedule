# docker/Dockerfile
# Dockerfile to build a PHP-Apache container for this application
FROM php:7.4-apache

# Enable PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy the application files to the container
COPY . /var/www/html/

# Set proper permissions (if needed)
RUN chown -R www-data:www-data /var/www/html/
