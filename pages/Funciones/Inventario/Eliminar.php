<?php
include('../../../config/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id']) && is_numeric($_POST['id'])) {
        $id = (int) $_POST['id'];
        $stmt = $conexion->prepare("DELETE FROM inventory WHERE id = ?");
        if ($stmt) {
            $stmt->bind_param("i", $id);
            if ($stmt->execute()) {
                echo "Eliminación de registro exitosa";
            } else {
                echo "Error al eliminar el registro: " . $stmt->error;
            }
            $stmt->close();
        } else {
            echo "Error en la preparación de la consulta: " . $conexion->error;
        }
    } else {
        echo "ID inválido.";
    }
} else {
    echo "Método no permitido.";
}


$conexion->close();
