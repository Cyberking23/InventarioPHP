<?php
// Tomamos los datos desde las variables de entorno de Railway
$host     = getenv("MYSQLHOST");
$port     = getenv("MYSQLPORT");
$user     = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$database = getenv("MYSQLDATABASE");

// Conexión con mysqli
$conexion = new mysqli($host, $user, $password, $database, $port);

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

echo "Conexión exitosa 🚀";
?>
