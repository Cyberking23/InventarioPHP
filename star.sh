
service mysql start

mysql -u root <<-EOSQL
    CREATE DATABASE IF NOT EXISTS db_ventas;
EOSQL

apachectl -D FOREGROUND
