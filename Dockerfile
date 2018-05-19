FROM drupalci/php-5.3.29-apache:production

MAINTAINER Roberto Arruda <robertoarruda@gmail.com>

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

CMD [ "php" ]