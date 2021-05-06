FROM php:7.4-apache-buster

COPY apache.conf /etc/apache2/sites-available/000-default.conf
COPY start.sh /usr/local/bin/start

RUN chown -R www-data:www-data /var/www/html \
    && chmod u+x /usr/local/bin/start \
    && a2enmod rewrite

RUN docker-php-ext-install mysqli pdo pdo_mysql

VOLUME /var/www/html

CMD ["/usr/local/bin/start"]