#EXAMPLE 2
FROM nginx:stable

ENV USER=laravel
ENV GROUP=laravel

RUN mkdir -p /var/www/html/public

ADD docker/nginx/default.conf /etc/nginx/conf.d/default.conf
#RUN sed -i "s/user www-data/user ${USER}/g" /etc/nginx/nginx.conf
RUN sed -i "s/user  nginx/user ${USER}/g" /etc/nginx/nginx.conf
#RUN adduser -g ${GROUP} -s /bin/sh -D ${USER}

RUN addgroup ${GROUP}
RUN adduser  --ingroup ${GROUP} --shell /bin/bash --disabled-login --disabled-password ${USER}