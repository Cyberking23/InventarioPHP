<?php
// Inicia sesión solo si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Incluye la conexión a la base de datos
include('../../../config/db.php'); 

// Verifica sesión activa
if (!isset($_SESSION['user_id'])) {
    header("Location: ../../index.php");
    exit();
}

// Verifica conexión
if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

// Establece la codificación UTF-8 para la conexión a la base de datos
$conexion->set_charset("utf8");

// Headers para que el navegador descargue un archivo CSV con codificación UTF-8
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=inventario.csv');

// BOM UTF-8 para que Excel reconozca la codificación UTF-8
echo "\xEF\xBB\xBF";

// Abre el "archivo" de salida para escribir
$output = fopen('php://output', 'w');

// Escribe la fila de encabezados
fputcsv($output, ['ID', 'Nombre', 'Categoría', 'Precio', 'Stock', 'Estado']);

// Consulta productos
$sql = "SELECT id, product_name, category, price, stock, status FROM inventory";
$result = $conexion->query($sql);

// Escribe cada fila del resultado en el CSV
while ($row = $result->fetch_assoc()) {
    fputcsv($output, [
        $row['id'],
        $row['product_name'],
        $row['category'],
        $row['price'],
        $row['stock'],
        $row['status'],
    ]);
}

fclose($output);
exit();
?>
