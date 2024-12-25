FROM php:8.2.27-fpm-alpine3.20



RUN docker-php-ext-install pdo pdo_mysql