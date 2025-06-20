FROM php:8.4-fpm
ENV PHP_VERSION=php8.4

WORKDIR "api"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update \
&& apt-get install -y --no-install-recommends apt-utils \
&& apt-get install -y net-tools \
&& apt-get install -y git \
&& apt-get install -y vim \
&& apt-get install -y curl \
&& apt-get install -y unzip \
&& apt-get install -y wget \
&& apt-get install -y libcurl4-gnutls-dev \
&& apt-get install -y libicu-dev \
&& apt-get install -y libmcrypt-dev \
&& apt-get install -y libpng-dev \
&& apt-get install -y libssl-dev \
&& apt-get install -y libxml2-dev \
&& apt-get install -y libsodium-dev \
&& apt-get install -y libzip-dev \
&& rm -rf /var/lib/apt/lists/*
        
RUN docker-php-ext-install pdo_mysql

RUN pecl install redis &&  docker-php-ext-enable redis
RUN pecl install xdebug

RUN echo "zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20240924/xdebug.so" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

RUN export XDEBUG_SESSION=phpstorm

RUN echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.remote_handler=dbgp" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.discover_client_host=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.client_host=172.19.0.1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini # ip docker
RUN echo "xdebug.client_port=9003" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.log=/mnt/api/data/logs/xdebug.log" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo "xdebug.idekey=phpstorm" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini


RUN curl -sS https://getcomposer.org/installer | php -- \ --install-dir=/usr/bin --filename=composer
