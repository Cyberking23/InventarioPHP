FROM ubuntu:22.04

ENV DEBIAN_FRONTEND=noninteractive

# Configura la zona horaria antes de instalar paquetes que la requieren
RUN ln -fs /usr/share/zoneinfo/America/El_Salvador /etc/localtime && \
    apt-get update && \
    apt-get install -y apache2 php php-mysqli php-pdo-mysql mysql-server libapache2-mod-php tzdata && \
    dpkg-reconfigure --frontend noninteractive tzdata && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./ /var/www/html/

RUN chown -R www-data:www-data /var/www/html

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

EXPOSE 80 3306

COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
