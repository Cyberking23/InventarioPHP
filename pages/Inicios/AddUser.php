<?php
include('../../config/db.php'); 

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        $mensaje = "Por favor completa todos los campos.";
    } else {
        // Crear hash seguro de la contraseña
        $pass_hash = password_hash($password, PASSWORD_BCRYPT);

        // Insertar en la base de datos
        $stmt = $conexion->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $pass_hash);

        if ($stmt->execute()) {
            $mensaje = "Usuario agregado correctamente ✅";
        } else {
            $mensaje = "Error al agregar usuario: " . $stmt->error;
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; padding: 50px; }
        form { background: #fff; padding: 20px; border-radius: 5px; max-width: 400px; margin: auto; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px 20px; }
        .mensaje { color: green; }
    </style>
</head>
<body>
    <form method="POST">
        <h2>Agregar Usuario</h2>
        <?php if($mensaje) echo "<p class='mensaje'>$mensaje</p>"; ?>
        <input type="text" name="username" placeholder="Nombre de usuario" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <button type="submit">Agregar Usuario</button>
    </form>
</body>
</html>
