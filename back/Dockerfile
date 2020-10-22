FROM wyveo/nginx-php-fpm:latest

WORKDIR /usr/share/nginx/

RUN rm -rf /usr/share/nginx/html

COPY ./back /usr/share/nginx

RUN chmod -R 777 /usr/share/nginx/storage/*
RUN ln -s public html
