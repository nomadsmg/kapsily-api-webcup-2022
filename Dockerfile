ARG PHP_VERSION=8.1
ARG CADDY_VERSION=2
ARG NODE_VERSION=14.17.0
ARG GIT_VERSION=2.26.2

FROM devilbox/php-fpm-${PHP_VERSION}:latest
WORKDIR "/api"

# Install PHP dependencies
RUN apt update; \
    apt install libpcre2-16-0 libpcre2-8-0 libpcre2-32-0 \
    apt -y --no-install-recommends install php${PHP_VERSION}-{curl,bcmath,bz2,ldap,memcached,mysql,xdebug,igbinary,msgpack,gd,phar,redis,xml,zip};\
    apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

# Install Git
RUN apt update && apt -y --no-install-recommends  install git

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
