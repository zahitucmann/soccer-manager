FROM php:8.1-fpm-alpine

ENV APP_HOME /var/www/html
ARG UID=1000
ARG GID=1000
ENV USERNAME=www-data

RUN apk update && apk add --no-cache \
    supervisor \
    bash 

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN chmod +x /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

# Remove Cache
RUN rm -rf /var/cache/apk/*

# add supervisor
RUN mkdir -p /var/log/supervisor
COPY --chown=root:root ./docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf


# set working directory
WORKDIR $APP_HOME

USER ${USERNAME}

# copy source files and config file
COPY --chown=${USERNAME}:${USERNAME} . $APP_HOME/
COPY --chown=${USERNAME}:${USERNAME} .env.dev $APP_HOME/.env

# install all PHP dependencies
RUN COMPOSER_MEMORY_LIMIT=-1 composer install --optimize-autoloader --no-interaction --no-progress;

CMD ["php-fpm"]