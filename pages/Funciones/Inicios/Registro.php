<?php
include('../../../config/db.php');

if ($conexion->connect_error) {
    die("Connection failed: " . $conexion->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $pass = $_POST['password'] ?? '';

    if (empty($user) || empty($email) || empty($pass)) {
        die("Por favor completa todos los campos.");
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Correo electrónico no válido.");
    }

    // Escapar datos para evitar inyección
    $user_safe = mysqli_real_escape_string($conexion, $user);
    $email_safe = mysqli_real_escape_string($conexion, $email);

    // Verificar si el usuario o email ya existen
    $sql_check = "SELECT COUNT(*) as count FROM users WHERE username = '$user_safe' OR email = '$email_safe'";
    $result = mysqli_query($conexion, $sql_check);
    $row = mysqli_fetch_assoc($result);

    if ($row['count'] > 0) {
        die("El nombre de usuario o correo ya está registrado.");
    }

    // ✅ Crear hash seguro de la contraseña
    $passHash = password_hash($pass, PASSWORD_BCRYPT);

    // Insertar usuario en la base de datos
    $sql_insert = "INSERT INTO users (username, email, password) VALUES ('$user_safe', '$email_safe', '$passHash')";

    if (mysqli_query($conexion, $sql_insert)) {
        echo "<script>
            alert('Registro exitoso. Por favor inicia sesión.');
            window.location.href = '../../Inicios/login.php';
        </script>";
        exit;
    } else {
        echo "Error al registrar: " . mysqli_error($conexion);
    }
} else {
    header('Location: register.html');
    exit;
}

mysqli_close($conexion);
?>
