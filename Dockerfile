FROM php:8.2-apache

# Install SQLite3
RUN apt-get update && apt-get install -y sqlite3 libsqlite3-dev

# Enable SQLite3 and PDO SQLite
RUN docker-php-ext-install pdo_sqlite

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set ServerName directive
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Configure Apache document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy application files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html/
RUN chmod -R 755 /var/www/html/

# Create SQLite database directory and set permissions
RUN mkdir -p /var/www/html/database
RUN chown -R www-data:www-data /var/www/html/database
RUN chmod -R 777 /var/www/html/database

# Create Apache configuration file
RUN echo '<Directory ${APACHE_DOCUMENT_ROOT}>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/document-root-directory.conf

RUN a2enconf document-root-directory