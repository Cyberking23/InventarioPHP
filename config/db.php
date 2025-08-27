<?php
$host     = "mysql.railway.internal";
$port     = 3306;
$user     = "root";
$password = "nJjPSgzJeXBczNtjIwqaYWZQxUKqmtjP";
$database = "railway";

$conexion = new mysqli($host, $user, $password, $database, $port);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}
echo "Conexión exitosa 🚀";
