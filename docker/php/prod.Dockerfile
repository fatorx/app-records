FROM php:8.3-fpm
ENV PHP_VERSION=php8.3

WORKDIR /mnt/api

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# APT-GET installs
RUN apt-get update \
&& apt-get install -y --no-install-recommends apt-utils \
&& apt-get install -y net-tools \
&& apt-get install -y git \
&& apt-get install -y vim \
&& apt-get install -y curl \
&& apt-get install -y unzip \
&& apt-get install -y libcurl4-gnutls-dev \
&& apt-get install -y libicu-dev \
&& apt-get install -y libmcrypt-dev \
&& apt-get install -y libpng-dev \
&& apt-get install -y libssl-dev \
&& apt-get install -y libxml2-dev \
&& apt-get install -y libsodium-dev \
&& apt-get install -y libzip-dev \
&& rm -rf /var/lib/apt/lists/*

# apt install php8.3 php8.3-cli php8.3-{bz2,curl,mbstring,intl,pdo_mysql,sockets, redis}

# PHP Deps
RUN docker-php-ext-install zip
RUN docker-php-ext-install sockets
RUN docker-php-ext-install pdo_mysql

RUN pecl install -o -f redis \
&&  rm -rf /tmp/pear \
&&  docker-php-ext-enable redis

# PHP Configuration
RUN echo "date.timezone=UTC" > /usr/local/etc/php/conf.d/timezone_sao_paulo.ini
RUN echo "upload_max_filesize=50M" >> /usr/local/etc/php/conf.d/max_size.ini

# Directories
# RUN mkdir -p /tmp/profiler && chmod 777 -R -f /tmp/profiler

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

EXPOSE 9000
EXPOSE 5601

# streams log
ENV LOG_STREAM="/tmp/stdout"
RUN mkfifo $LOG_STREAM && chmod 777 $LOG_STREAM

CMD ["php-fpm"]
