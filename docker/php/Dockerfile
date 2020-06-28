FROM php:zts-alpine

WORKDIR /var/www

RUN apk --update upgrade
RUN apk add autoconf gcc g++ make
RUN pecl install parallel && docker-php-ext-enable parallel

EXPOSE 8000
CMD ["php", "-S", "0.0.0.0:8000"]