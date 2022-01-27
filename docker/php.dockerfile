#EXAMPLE 2
FROM php:8-fpm

ENV USER=laravel
ENV GROUP=laravel

#Create a new group and user
RUN addgroup ${GROUP}
RUN adduser  --ingroup ${GROUP} --shell /bin/bash --disabled-login --disabled-password ${USER}

#Search and replace www-data user in php-fpm with our user 
RUN sed -i "s/www-data/${USER}/g" /usr/local/etc/php-fpm.d/www.conf
#RUN sed -i "s/group = www-data/group ${GROUP}/g" /usr/local/etc/php-fpm.d/www.conf

RUN mkdir -p /var/www/html/public

#Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer -v

#Install and enable zip
RUN apt-get update && apt-get install -y unzip  libzip-dev

#Install nano
RUN apt-get update && apt-get install -y nano

#Install and enable Redis
RUN pecl install redis \
    && docker-php-ext-enable redis

#Enable gd libraries
RUN apt-get update && apt-get install -y unzip libfreetype6-dev libjpeg62-turbo-dev libpng-dev zlib1g-dev
RUN docker-php-ext-install zip
RUN docker-php-ext-enable zip
RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install  gd
#Install and enable pdo
RUN docker-php-ext-install pdo pdo_mysql

#Change memory limit
RUN cd /usr/local/etc/php/conf.d/ && \
  echo 'memory_limit = -1' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini


CMD ["php-fpm","-y","/usr/local/etc/php-fpm.conf","-R"]