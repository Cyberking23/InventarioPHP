FROM ubuntu:22.04

# Evitar que apt-get pida interacción durante instalación
ENV DEBIAN_FRONTEND=noninteractive

# Configurar zona horaria para evitar mensajes relacionados con tzdata
RUN ln -fs /usr/share/zoneinfo/America/El_Salvador /etc/localtime && \
    apt-get update && \
    apt-get install -y tzdata && \
    dpkg-reconfigure --frontend noninteractive tzdata

# Instalar Apache, PHP, MySQL y módulos necesarios
RUN apt-get update && apt-get install -y \
    apache2 \
    php \
    php-mysqli \
    php-pdo-mysql \
    mysql-server \
    libapache2-mod-php \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copiar el código PHP al directorio web de Apache
COPY ./ /var/www/html/

# Cambiar permisos para que Apache pueda acceder y servir los archivos
RUN chown -R www-data:www-data /var/www/html

# Configurar Apache para evitar advertencias sobre ServerName
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Opcional: asegurarse que Apache busque index.php primero
RUN sed -i 's/DirectoryIndex .*/DirectoryIndex index.php index.html/' /etc/apache2/mods-enabled/dir.conf

# Exponer puertos para Apache (80) y MySQL (3306)
EXPOSE 80 3306

# Copiar script de inicio y darle permisos de ejecución
COPY start.sh /start.sh
RUN chmod +x /start.sh

# Ejecutar el script de inicio al iniciar el contenedor
CMD ["/start.sh"]
