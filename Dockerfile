FROM php:8.1-apache

RUN pecl install xdebug-3.1.4 \
	&& docker-php-ext-enable xdebug

# install php extensions with docker-php-ext-install (no need for phar)
RUN docker-php-ext-install pdo pdo_mysql mysqli  \
    && docker-php-ext-enable pdo pdo_mysql mysqli
