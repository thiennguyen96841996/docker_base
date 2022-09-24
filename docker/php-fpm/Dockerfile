FROM php:8.1-fpm-bullseye

WORKDIR /usr/src/app

ENV TZ Asia/Tokyo
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update && \
    apt-get -y install --no-install-recommends \
      git  \
      unzip  \
      libzip-dev \
      libicu-dev \
      libonig-dev \
      zlib1g-dev \
      libfreetype6-dev \
      libpng-dev \
      libjpeg62-turbo-dev \
      libwebp-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-configure gd \
      --with-freetype \
      --with-jpeg \
      --with-webp && \
    docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install -j$(nproc) \
      intl \
      pdo_mysql \
      bcmath \
      zip \
      opcache

RUN pecl install xdebug redis && \
    docker-php-ext-enable xdebug redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
ENV COMPOSER_DISABLE_XDEBUG_WARN 1
ENV COMPOSER_MEMORY_LIMIT -1

COPY files/conf/php.ini            /usr/local/etc/php/php.ini
COPY files/conf/php-fpm.d/www.conf /usr/local/etc/php-fpm.d/www.conf

EXPOSE 9000
