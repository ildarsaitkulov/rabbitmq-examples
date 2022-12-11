FROM php:8.2

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN chmod +x /usr/local/bin/install-php-extensions && install-php-extensions amqp
WORKDIR /opt/rabbitmq-examples

CMD php -S 0.0.0.0:8000 -t /opt/rabbitmq-examples