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

# Copiar el código PHP al directorio web de Apache
COPY ./ /var/www/html/

# Cambiar permisos para que Apache pueda acceder y servir los archivos
RUN chown -R www-data:www-data /var/www/html

# Configurar Apache para evitar advertencias sobre ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Exponer puertos para Apache (80) y MySQL (3306)
EXPOSE 80 3306

# Copiar script de inicio y darle permisos de ejecución
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Ejecutar el script de inicio al iniciar el contenedor
CMD ["/start.sh"]
