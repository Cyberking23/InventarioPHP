<?php
include('../../../config/db.php');

session_start();

if ($conexion->connect_error) {
  die("Connection failed: " . $conexion->connect_error);
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../index.php");
  exit();
}

$username = $_SESSION['username'];

// Número de registros por página
$registros_por_pagina = 10;

// Obtener número de página actual desde URL (default 1)
$pagina_actual = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? (int)$_GET['pagina'] : 1;

// Calcular el índice para LIMIT
$offset = ($pagina_actual - 1) * $registros_por_pagina;

// Consulta para obtener total de registros
$resultado_total = $conexion->query("SELECT COUNT(*) as total FROM inventory");
$total_registros = $resultado_total->fetch_assoc()['total'];

// Calcular número total de páginas
$total_paginas = ceil($total_registros / $registros_por_pagina);

// Consulta paginada para obtener solo registros de la página actual
$sql = "SELECT id, product_name, category, price, stock, status FROM inventory LIMIT $registros_por_pagina OFFSET $offset";
$resultado = $conexion->query($sql);
?>
