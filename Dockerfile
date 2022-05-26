FROM php:8.1-apache
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN apt-get update && apt-get install -y mariadb-client
RUN mkdir /backups && chmod a+w /backups
COPY src/ /var/www/html/
