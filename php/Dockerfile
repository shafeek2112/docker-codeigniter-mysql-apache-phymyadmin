FROM php:7.3.3-apache

RUN docker-php-ext-install mysqli

RUN a2enmod rewrite

ADD . /var/www/html

EXPOSE 80