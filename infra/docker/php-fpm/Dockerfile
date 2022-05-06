FROM devilbox/php-fpm-8.1:latest
WORKDIR "/api"

ENV NODE_VERSION=14.17.0

RUN apt update; \
    apt install libpcre2-16-0 libpcre2-8-0 libpcre2-32-0 \
    apt -y --no-install-recommends install \
        php8.1-curl \ 
        php8.1-bcmath \ 
        php8.1-bz2 \ 
        php8.1-ldap \ 
        php8.1-memcached \ 
        php8.1-mysql \
        php8.1-xdebug \
        php8.1-igbinary \
        php8.1-msgpack \
        php8.1-gd \
        php8.1-phar \
        php8.1-redis \
        php8.1-xml \
        php8.1-zip; \
    apt-get clean
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -L -o /tmp/nodejs.tar.gz https://nodejs.org/dist/v${NODE_VERSION}/node-v${NODE_VERSION}-linux-x64.tar.gz
RUN tar xfvz /tmp/nodejs.tar.gz -C /usr/local --strip-components=1 && \
    rm -f /tmp/nodejs.tar.gz

RUN npm install yarn -g