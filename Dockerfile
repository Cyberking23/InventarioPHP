FROM ubuntu:22.04

RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    php-mysqli \
    php-pdo-mysql \
    mysql-server \
    libapache2-mod-php \
    && apt-get clean

COPY ./ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80 3306

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
