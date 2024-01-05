FROM php:7.4-apache

COPY . /var/www/html


COPY apache-config.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite
RUN a2ensite 000-default


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN composer require vlucas/phpdotenv