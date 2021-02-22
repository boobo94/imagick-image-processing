FROM php:7.2.6-apache

# RUN docker-php-ext-install mysql mysqli

RUN apt-get update -y && apt-get install -y libpng-dev

RUN apt-get update && apt-get install -y libmagickwand-dev --no-install-recommends && rm -rf /var/lib/apt/lists/*
RUN printf "\n" | pecl install imagick
RUN docker-php-ext-enable imagick

# RUN apt-get update && \
#     apt-get install -y \
#         zlib1g-dev 

# RUN docker-php-ext-install mbstring

# RUN docker-php-ext-install zip

RUN docker-php-ext-install gd