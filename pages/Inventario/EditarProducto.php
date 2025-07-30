<?php
include('../../config/db.php');

// Validar que haya un ID en la URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Consulta segura con prepare
    $stmt = $conexion->prepare("SELECT * FROM inventory WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $producto = $resultado->fetch_assoc();
    } else {
        echo "Producto no encontrado.";
        exit;
    }

    $stmt->close();
    $conexion->close();
} else {
    echo "ID inválido.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Editar Producto - SalesHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 min-h-screen flex items-center justify-center font-sans text-gray-800">
  <div class="bg-white/90 backdrop-blur-md rounded-xl shadow-lg p-10 max-w-md w-full">
    <h2 class="text-2xl font-bold text-blue-700 mb-6 text-center">Editar Producto</h2>
    
    <form action="../Funciones/Inventario/Actualizar.php" method="POST" class="space-y-5">
      
      <!-- ID oculto -->
      <input type="hidden" name="id" value="<?= isset($producto['id']) ? htmlspecialchars($producto['id']) : '' ?>">

      <div>
        <label for="product_name" class="block mb-1 text-blue-600 font-semibold">Nombre del Producto</label>
        <input type="text" id="product_name" name="product_name" required
               value="<?= isset($producto['product_name']) ? htmlspecialchars($producto['product_name']) : '' ?>"
               class="w-full px-4 py-3 border rounded-lg border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="category" class="block mb-1 text-blue-600 font-semibold">Categoría</label>
        <input type="text" id="category" name="category" 
               value="<?= isset($producto['category']) ? htmlspecialchars($producto['category']) : '' ?>"
               class="w-full px-4 py-3 border rounded-lg border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="price" class="block mb-1 text-blue-600 font-semibold">Precio ($)</label>
        <input type="number" step="0.01" id="price" name="price" required
               value="<?= isset($producto['price']) ? htmlspecialchars($producto['price']) : '' ?>"
               class="w-full px-4 py-3 border rounded-lg border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="stock" class="block mb-1 text-blue-600 font-semibold">Stock</label>
        <input type="number" id="stock" name="stock" required
               value="<?= isset($producto['stock']) ? htmlspecialchars($producto['stock']) : '' ?>"
               class="w-full px-4 py-3 border rounded-lg border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <div>
        <label for="status" class="block mb-1 text-blue-600 font-semibold">Estado</label>
        <select id="status" name="status" required
                class="w-full px-4 py-3 border rounded-lg border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
          <option value="activo" <?= (isset($producto['status']) && $producto['status'] === 'activo') ? 'selected' : '' ?>>Activo</option>
          <option value="inactivo" <?= (isset($producto['status']) && $producto['status'] === 'inactivo') ? 'selected' : '' ?>>Inactivo</option>
        </select>
      </div>

      <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition">Actualizar Producto</button>
    </form>

    <a href="./Inventario.php">
      <button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 mt-5 rounded-lg font-semibold transition">Regresar</button>
    </a>
  </div>
</body>
</html>
