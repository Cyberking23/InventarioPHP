#!/bin/bash

service mysql start

mysql -u root <<-EOSQL
    CREATE DATABASE IF NOT EXISTS db_ventas;
EOSQL

# Esto asegura que Apache busque index.php primero
echo "DirectoryIndex index.php index.html" >> /etc/apache2/apache2.conf

apachectl -D FOREGROUND
