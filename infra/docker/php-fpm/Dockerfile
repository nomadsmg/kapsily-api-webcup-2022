ARG PHP_VERSION=8.1
ARG CADDY_VERSION=2
ARG NODE_VERSION=14.17.0

FROM devilbox/php-fpm-${PHP_VERSION}:latest
WORKDIR "/api"

# Install PHP dependencies
RUN apt update; \
    apt install libpcre2-16-0 libpcre2-8-0 libpcre2-32-0 \
    apt -y --no-install-recommends install \
        php${PHP_VERSION}-curl \ 
        php${PHP_VERSION}-bcmath \ 
        php${PHP_VERSION}-bz2 \ 
        php${PHP_VERSION}-ldap \ 
        php${PHP_VERSION}-memcached \ 
        php${PHP_VERSION}-mysql \
        php${PHP_VERSION}-xdebug \
        php${PHP_VERSION}-igbinary \
        php${PHP_VERSION}-msgpack \
        php${PHP_VERSION}-gd \
        php${PHP_VERSION}-phar \
        php${PHP_VERSION}-redis \
        php${PHP_VERSION}-xml \
        php${PHP_VERSION}-zip; \
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install NodeJs
RUN curl -sS https://deb.nodesource.com/setup_14.x | bash -
# RUN apt update && apt install nodejs -y 
RUN apt update; \
    apt -y --no-install-recommends  install nodejs \
    build-essential

RUN echo $(node --version)
RUN echo $(npm --version)

# # Install Yarn
RUN npm install yarn -g