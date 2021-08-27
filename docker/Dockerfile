FROM php:8.0-apache

# ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apt-get update -y --fix-missing && apt-get upgrade -y

# Install LDAP
RUN apt-get install -y libldb-dev libldap2-dev && docker-php-ext-install -j$(nproc) ldap 

# Instal reuqired extentions
RUN install-php-extensions pdo_pgsql gd zip bcmath @composer-2.0.2


# install the ssl-cert package which will create a "snakeoil" keypair
RUN apt-get update \
    && DEBIAN_FRONTEND=noninteractive apt-get install -y ssl-cert \
    && rm -r /var/lib/apt/lists/*

# enable ssl module and enable the default-ssl site
RUN a2enmod ssl \
    && a2ensite default-ssl

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN a2enmod rewrite


COPY configs/testware.conf /etc/apache2/sites-available/000-default.conf
COPY configs/.env /var/www/html/.env

# Set working directory
WORKDIR /var/www/html

# Copy application
COPY /testware  /var/www/html  


RUN cd /var/www/html \
    && composer update && composer install 


RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/ -type f -exec chmod 664 {} \; \
    && find /var/www/html/ -type d -exec chmod 775 {} \; \
    && chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

# USER www-data

EXPOSE 80 443