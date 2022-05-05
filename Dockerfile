FROM php:8.1-fpm-bullseye AS base

WORKDIR /var/www

# timezone environment
ENV TZ=UTC \
  # locale
  LANG=en_US.UTF-8 \
  LANGUAGE=en_US:en \
  LC_ALL=en_US.UTF-8 \
  # composer environment
  COMPOSER_ALLOW_SUPERUSER=1 \
  COMPOSER_HOME=/composer

COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

RUN apt-get update \
  && apt-get -y install --no-install-recommends \
    locales \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    libonig-dev \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* \
  && locale-gen en_US.UTF-8 \
  && localedef -f UTF-8 -i en_US en_US.UTF-8 \
  && docker-php-ext-install \
    intl \
    pdo_mysql \
    zip \
    bcmath \
  && composer config -g process-timeout 3600 \
  && composer config -g repos.packagist composer https://packagist.org

FROM base AS development

COPY ./infra/docker/php/php.development.ini /usr/local/etc/php/php.ini

# FROM base AS deploy

# COPY ./infra/docker/php/php.deploy.ini /usr/local/etc/php/php.ini
# COPY ./src /var/www

CMD ["sh", "-c", "chmod -R 777 /var/www/storage && chmod -R 777 /var/www/bootstrap/cache && php-fpm"]
