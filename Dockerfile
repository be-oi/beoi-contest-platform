FROM php:7.0-apache

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/bin
RUN php -r "unlink('composer-setup.php');"

RUN sed -i s/deb.debian.org/archive.debian.org/g /etc/apt/sources.list
RUN sed -i s/security.debian.org/archive.debian.org/g /etc/apt/sources.list
RUN sed -i s/stretch-updates/stretch/g /etc/apt/sources.list
RUN apt-get update
RUN apt-get -y install git unzip nodejs-legacy nodejs vim mysql-client gnupg
RUN curl -sL https://deb.nodesource.com/setup_10.x | bash -
RUN apt-get -y install nodejs
RUN npm install -g bower

COPY composer.json composer.lock /var/www/html/
RUN composer.phar install

COPY config/apache.conf /etc/apache2/sites-available/contest.conf
RUN a2enmod headers proxy proxy_balancer proxy_http
RUN a2dissite 000-default
RUN a2ensite contest
RUN mkdir /var/www/html/logs && ln -s /var/log/apache2 /var/www/html/logs/apache

RUN docker-php-ext-install mysqli pdo pdo_mysql

## APT Cleanup
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY contestInterface/bower.json /var/www/html/contestInterface/
RUN cd /var/www/html/contestInterface && bower install --allow-root
COPY teacherInterface/bower.json /var/www/html/teacherInterface/
RUN cd /var/www/html/teacherInterface && bower install --allow-root


COPY . /var/www/html
RUN chown -R www-data:www-data *

EXPOSE 80