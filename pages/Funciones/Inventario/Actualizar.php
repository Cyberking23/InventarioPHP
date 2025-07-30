<?php
include('../../../config/db.php'); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar campos recibidos
    $id = isset($_POST['id']) && is_numeric($_POST['id']) ? (int)$_POST['id'] : null;
    $product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
    $category = isset($_POST['category']) ? trim($_POST['category']) : null;
    $price = isset($_POST['price']) ? (float)$_POST['price'] : null;
    $stock = isset($_POST['stock']) ? (int)$_POST['stock'] : null;
    $status = isset($_POST['status']) ? $_POST['status'] : null;

    // Validaciones básicas
    if (!$id || $product_name === '' || $price === null || $stock === null || !in_array($status, ['activo', 'inactivo'])) {
        echo "Datos inválidos.";
        exit;
    }

    // Preparar la consulta para actualizar
    $stmt = $conexion->prepare("UPDATE inventory SET product_name = ?, category = ?, price = ?, stock = ?, status = ? WHERE id = ?");
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        exit;
    }

    // Bind de parámetros (sssssi: string, string, string, string, string, int)
    $stmt->bind_param("ssdisi", $product_name, $category, $price, $stock, $status, $id);

    if ($stmt->execute()) {
        // Redireccionar o mostrar mensaje
        header("Location: ../../Inventario/Inventario.php");
        exit;
    } else {
        echo "Error al actualizar el producto: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Método no permitido.";
}

$conexion->close();

?>