ARG PHP_VERSION=8.1
ARG CADDY_VERSION=2
ARG NODE_VERSION=14.17.0
ARG GIT_VERSION=2.26.2

#FROM devilbox/php-fpm-${PHP_VERSION}:latest
FROM phpdockerio/php:${PHP_VERSION}-fpm
WORKDIR "/api"

# Install PHP dependencies
RUN apt-get update; \
    apt-get -y --no-install-recommends install \
        git \ 
        php8.1-amqp \ 
        php8.1-bz2 \ 
        php8.1-gd \ 
        php8.1-gmagick \ 
        php8.1-grpc \ 
        php8.1-http \ 
        php8.1-imagick \ 
        php8.1-imap \ 
        php8.1-intl \ 
        php8.1-mcrypt \ 
        php8.1-memcache \ 
        php8.1-memcached \ 
        php8.1-mongodb \ 
        php8.1-mysql \ 
        php8.1-odbc \ 
        php8.1-pgsql \ 
        php8.1-redis \ 
        php8.1-sqlite3 \ 
        php8.1-uuid \ 
        php8.1-xdebug \ 
        php8.1-xmlrpc \ 
        php8.1-xsl \ 
        php8.1-yaml \ 
        php8.1-zip \ 
        php8.1-zmq; \
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

# # Install Yarn
RUN npm install yarn -g

RUN echo "GIT VERSION: "$(git --version)"\n";\
    echo "PHP VERSION: "$(php --version)"\n";\
    echo "NODE VERSION: "$(node --version)"\n";\
    echo "YARN VERSION: "$(yarn --version)"\n";
