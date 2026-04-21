FROM php:8.3-apache AS base

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN apt-get update && \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends postgresql-client ssl-cert && \
    make-ssl-cert generate-default-snakeoil --force-overwrite && \
    rm -rf /var/lib/apt/lists/*

RUN install-php-extensions pdo_pgsql gd zip bcmath

RUN a2enmod ssl && a2ensite default-ssl && a2enmod rewrite

COPY docker/configs/testware.conf /etc/apache2/sites-available/000-default.conf
COPY docker/configs/custom.ini /usr/local/etc/php/conf.d/custom.ini


# --- Composer Stage ---
FROM base AS composer

RUN install-php-extensions @composer

WORKDIR /var/www/html

# composer.json/lock liegen im Repo-Root
COPY composer.json composer.lock ./
COPY database/ database/

RUN composer install --no-interaction --no-dev --optimize-autoloader --no-scripts

# Rest der App kopieren, aber nicht vendor/, node_modules/ etc.
COPY --exclude=docker \
     --exclude=node_modules \
     --exclude=vendor \
     --exclude=.git \
     . .

RUN composer run-script post-autoload-dump --no-interaction || true


# --- Final Stage ---
FROM base AS final

WORKDIR /var/www/html

COPY --from=composer /var/www/html .
# copy SSL certificates from the base stage
COPY --from=base /etc/ssl/private/ssl-cert-snakeoil.key /etc/ssl/private/
COPY --from=base /etc/ssl/certs/ssl-cert-snakeoil.pem /etc/ssl/certs/

RUN chown -R www-data:www-data /var/www/html && \
    find /var/www/html/ -type f -exec chmod 664 {} \; && \
    find /var/www/html/ -type d -exec chmod 775 {} \; && \
    chgrp -R www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R ug+rwx /var/www/html/storage /var/www/html/bootstrap/cache

USER www-data

EXPOSE 80 443