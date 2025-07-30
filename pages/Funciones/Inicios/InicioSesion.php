<?php
session_start();
include('../../../config/db.php');

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (empty($email) || empty($pass)) {
        die("Por favor completa todos los campos.");
    }

    // Preparar consulta para buscar usuario por email
    $stmt = $conexion->prepare("SELECT id, username, email, password FROM users WHERE email = ?");
    if (!$stmt) {
        die("Error en la consulta: " . $conexion->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();
        if (password_verify($pass, $usuario['password'])) {
            // Login exitoso, guardar datos en sesión
            $_SESSION['user_id'] = $usuario['id'];
            $_SESSION['username'] = $usuario['username'];
            header("Location: ../../Inventario/Inventario.php");
            exit;
        } else {
            // Contraseña incorrecta
            echo "<script>
                alert('Contraseña incorrecta. Intenta de nuevo.');
                window.location.href = '../../Inicios/Login.php';
            </script>";
            exit;
        }
    } else {
        // Usuario no encontrado
        echo "<script>
            alert('Usuario no encontrado. Verifica tu correo.');
            window.location.href = '../../Inicios/Login.php';
        </script>";
        exit;
    }

    $stmt->close();
} else {
    header("Location: ../../Inicios/Login.php");
    exit;
}
