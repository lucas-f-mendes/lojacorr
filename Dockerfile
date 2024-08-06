FROM php:8.2-apache

ARG USER_ID=1000
ARG GROUP_ID=1000
ARG HOME_DIR=/home/www-data

WORKDIR /var/www/html

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update \
    && apt-get install -y libzip-dev zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite
RUN docker-php-ext-install pdo_mysql zip
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

COPY . WORKDIR

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN mkdir ${HOME_DIR} \
    && chown -R ${USER_ID}:${GROUP_ID} ${HOME_DIR} \
    && usermod --uid ${USER_ID} --home ${HOME_DIR} --shell /bin/bash www-data \
    && groupmod --gid ${GROUP_ID} www-data \
    && adduser www-data sudo \
    && adduser www-data adm \
    && echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

USER www-data