FROM php:8.3-apache

# Aktifkan extension mysqli
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan mod_rewrite (jika diperlukan)
RUN a2enmod rewrite

WORKDIR /var/www/html

COPY . /var/www/html/

EXPOSE 80