<?php
include('../../../config/db.php'); // Asegúrate de tener bien la ruta

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitizamos entradas
    $product_name = trim($_POST['product_name'] ?? '');
    $category     = trim($_POST['category'] ?? '');
    $price        = floatval($_POST['price'] ?? 0);
    $stock        = intval($_POST['stock'] ?? 0);
    $status       = $_POST['status'] ?? 'activo';

    // Validación básica
    if (empty($product_name) || empty($category) || $price <= 0 || $stock < 0) {
        echo "<script>alert('Por favor completa todos los campos correctamente.'); window.history.back();</script>";
        exit;
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO inventory (product_name, category, price, stock, status)
            VALUES ('$product_name', '$category', $price, $stock, '$status')";

    if (mysqli_query($conexion, $sql)) {
        echo "<script>alert('Producto añadido correctamente.'); window.location.href = '../../Inventario/Inventario.php';</script>";
    } else {
        echo "Error al guardar producto: " . mysqli_error($conexion);
    }
}
?>
