ARG HANDLE_FILES

FROM php:8.0.14-fpm AS base

WORKDIR /var/www

RUN apt-get update
RUN apt-get install -y openssl
RUN apt-get install -y build-essential
RUN apt-get install -y libpng-dev
RUN apt-get install -y libjpeg62-turbo-dev
RUN apt-get install -y libfreetype6-dev
RUN apt-get install -y libonig-dev
RUN apt-get install -y libxml2-dev
RUN apt-get install -y locales
RUN apt-get install -y zip
RUN apt-get install -y libzip-dev
RUN apt-get install -y jpegoptim optipng pngquant gifsicle
RUN apt-get install -y vim
RUN apt-get install -y unzip
RUN apt-get install -y git
RUN apt-get install -y curl
RUN apt-get install -y nano
#RUN apt-get install -y librdkafka-dev
RUN apt-get install -y iputils-ping

#RUN pecl install rdkafka

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install mbstring
RUN docker-php-ext-install zip
RUN docker-php-ext-install exif
RUN docker-php-ext-install pcntl
RUN docker-php-ext-install bcmath
RUN docker-php-ext-install ctype
RUN docker-php-ext-install tokenizer
# RUN docker-php-ext-install json
RUN docker-php-ext-install xml
RUN docker-php-ext-install simplexml
RUN docker-php-ext-configure gd
# RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/
RUN docker-php-ext-install gd
RUN docker-php-ext-install opcache
#RUN docker-php-ext-enable rdkafka

# # install and enable xdebug
# RUN apk add --no-cache $PHPIZE_DEPS \
# 	&& pecl install xdebug-2.9.7 \
# 	&& docker-php-ext-enable xdebug

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -G root www-data
RUN chown -R www-data:www-data /var/www
RUN useradd -u 1000 -ms /bin/bash -g root www

FROM base AS mount_volume

FROM base as copy_files
COPY . /var/www
RUN chmod -R 777 /var/www/storage
RUN chmod -R 777 /var/www/bootstrap/cache

FROM ${HANDLE_FILES:-base}
USER root
EXPOSE 9000
CMD ["sh", "-c", "chmod -R 777 /var/www/storage && chmod -R 777 /var/www/bootstrap/cache && php-fpm"]
