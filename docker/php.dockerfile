FROM php:7.4-fpm-alpine

######### 准备工作 #####
# 先修改源
RUN sed -i 's/dl-cdn.alpinelinux.org/mirrors.tuna.tsinghua.edu.cn/g' /etc/apk/repositories
# 安装pecl
RUN apk add --no-cache pcre-dev $PHPIZE_DEPS

######### 准备工作END #####



ADD php/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN addgroup -g 1000 laravel && adduser -G laravel -g laravel -s /bin/sh -D laravel

RUN mkdir -p /var/www/html

RUN chown laravel:laravel /var/www/html

WORKDIR /var/www/html

RUN docker-php-ext-install pdo pdo_mysql
# 安装redis拓展
RUN pecl install redis \
    &&  docker-php-ext-enable redis.so