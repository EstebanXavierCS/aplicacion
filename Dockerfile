FROM php:8.2-apache

# Install SQLite3
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev

# Enable SQLite3 and PDO SQLite
RUN docker-php-ext-install pdo_sqlite

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Create SQLite database directory and set permissions
RUN mkdir -p /var/www/html/database
RUN chown -R www-data:www-data /var/www/html/database
RUN chmod -R 755 /var/www/html/database