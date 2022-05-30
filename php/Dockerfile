FROM php:7.2-apache
ENV TZ="Asia/Bangkok"
RUN apt-get update && \
    apt-get install -y \
        zlib1g-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql zip
RUN a2enmod rewrite
