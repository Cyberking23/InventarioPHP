FROM ubuntu:22.04

# Instalar Apache, PHP y MySQL server
RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    php-mysqli \
    php-pdo-mysql \
    mysql-server \
    libapache2-mod-php \
    && apt-get clean

# Copiar tu código PHP al directorio web
COPY ./ /var/www/html/

# Cambiar permisos para Apache
RUN chown -R www-data:www-data /var/www/html

# Configurar Apache para que corra en primer plano
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puerto 80 y 3306 (MySQL)
EXPOSE 80 3306

# Copiar y dar permisos al script de inicio
COPY start.sh /start.sh
RUN chmod +x /start.sh

CMD ["/start.sh"]
