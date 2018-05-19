FROM drupalci/php-5.3.29-apache:production

MAINTAINER Roberto Arruda <robertoarruda@gmail.com>

RUN usermod -u 1000 www-data

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'alias ll="ls -l --color=auto"' >> ~/.bashrc

CMD [ "php" ]