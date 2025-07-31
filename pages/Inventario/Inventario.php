<?php
include("../../config/db.php");
session_start();

if ($conexion->connect_error) {
  die("Connection failed: " . $conexion->connect_error);
}

if (!isset($_SESSION['user_id'])) {
  header("Location: ../../index.php");
  exit();
}

$username = $_SESSION['username'];

// Parámetros de búsqueda
$busqueda = isset($_GET['busqueda']) ? $conexion->real_escape_string($_GET['busqueda']) : '';

// Paginación
$por_pagina = 10; // Productos por página
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) $pagina_actual = 1;

$inicio = ($pagina_actual - 1) * $por_pagina;

// Consulta total con posible búsqueda
$total_sql = "SELECT COUNT(*) AS total FROM inventory";
if (!empty($busqueda)) {
  $total_sql .= " WHERE product_name LIKE '%$busqueda%'";
}
$total_result = $conexion->query($total_sql);
$total_fila = $total_result->fetch_assoc();
$total_registros = $total_fila['total'];
$total_paginas = ceil($total_registros / $por_pagina);

// Consulta principal con límite y búsqueda
$sql = "SELECT id, product_name, category, price, stock, status 
        FROM inventory";
if (!empty($busqueda)) {
  $sql .= " WHERE product_name LIKE '%$busqueda%'";
}
$sql .= " LIMIT $inicio, $por_pagina";

$resultado = $conexion->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Futuristic Inventory UI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 text-gray-800 font-sans min-h-screen">
  <!-- Header -->
  <header class="flex items-center justify-between p-6 shadow-md bg-white/80 backdrop-blur-md">
    <div class="flex items-center space-x-3">
      <div class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold">S</div>
      <span class="text-2xl font-semibold tracking-wide">SalesHub</span>
    </div>
    <form method="GET" action="Inventario.php" class="mb-4">
      <input
        type="text"
        name="busqueda"
        placeholder="Buscar herramientas"
        value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>"
        class="border border-gray-300 px-3 py-2 rounded" />
      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded ml-2 hover:bg-blue-700">
        Buscar
      </button>
      <a href="Inventario.php" class="bg-blue-500 text-white px-4 py-2 rounded ml-2 hover:bg-blue-600">
        Ver todos
      </a>

    </form>


    <div class="flex items-center space-x-4">
      <a href="../Funciones/Inventario/Logout.php"><i data-lucide="log-out" class="w-5 h-5 text-blue-600 cursor-pointer"></i></a>
      <div class="flex items-center space-x-1 cursor-pointer">
        <div class="bg-blue-500 text-white text-sm rounded-full w-8 h-8 flex items-center justify-center">
          <?= strtoupper(substr($_SESSION['username'], 0, 1)) ?>
        </div>
        <span class="text-sm"><?= htmlspecialchars($_SESSION['username']) ?></span>
        <i data-lucide="chevron-down" class="w-4 h-4 text-blue-500"></i>
      </div>
    </div>
  </header>

  <div class="flex">
    <!-- Sidebar -->
    <aside class="w-60 h-screen bg-white/90 backdrop-blur-md shadow-md p-6 space-y-6">
      <nav class="space-y-4 text-gray-700">
        <a href="#" class="flex items-center gap-2 text-blue-600 font-semibold">
          <i data-lucide="home" class="w-5 h-5"></i> <span>Dashboard</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8 space-y-8">
      <!-- Title -->
      <div class="flex items-center justify-between">
        <h1 class="text-3xl font-bold">Inventory</h1>
        <a href="../Funciones/Inventario/CSV.php"><button class="bg-red-600 text-white px-4 py-2 rounded shadow hover:bg-red-700">Exportar CSV</button></a>
        <a href="./AñadirProducto.php"><button class="bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700">Añadir Producto</button></a>

      </div>

      <!-- Table -->

      <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="w-full text-left">
          <thead class="bg-gradient-to-r from-blue-500 to-indigo-500 text-white">
            <tr>
              <th class="p-4">#</th>
              <th class="p-4">Product</th>
              <th class="p-4">Category</th>
              <th class="p-4">Price</th>
              <th class="p-4">Stock</th>
              <th class="p-4">Status</th>
              <th class="p-4">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            <?php if ($resultado->num_rows > 0): ?>
              <?php while ($row = $resultado->fetch_assoc()): ?>
                <tr class="hover:bg-blue-50">
                  <td class="p-4"><?php echo $row['id']; ?></td>
                  <td class="p-4"><?php echo htmlspecialchars($row['product_name']); ?></td>
                  <td class="p-4"><?php echo htmlspecialchars($row['category']); ?></td>
                  <td class="p-4">$<?php echo number_format($row['price'], 2); ?></td>
                  <td class="p-4"><?php echo $row['stock']; ?></td>
                  <td class="p-4 font-semibold <?php echo ($row['status'] === 'activo' ? 'text-green-600' : 'text-red-600'); ?>">
                    <?php echo ucfirst($row['status']); ?>
                  </td>
                  <td class="p-4 space-x-2">
                    <a href="./EditarProducto.php?id=<?= $row['id'] ?>" class="text-sm text-blue-600 hover:underline">Editar</a>
                    <form action="../Funciones/Inventario/Eliminar.php" method="post" onsubmit="return confirm('¿Estás seguro de eliminar este producto?');" style="display:inline;">
                      <input type="hidden" name="id" value="<?= $row['id'] ?>">
                      <button type="submit" class="text-sm text-red-600 hover:underline bg-transparent border-0 cursor-pointer p-0">
                        Eliminar
                      </button>
                    </form>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="7" class="p-4 text-center text-gray-500">No hay productos registrados.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

      <!-- Paginación -->
      <div class="mt-4">
        <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
          <a href="?pagina=<?= $i ?>&busqueda=<?= urlencode($busqueda) ?>"
            class="px-3 py-1 border rounded <?= $i == $pagina_actual ? 'bg-blue-600 text-white' : 'bg-gray-200' ?>">
            <?= $i ?>
          </a>
        <?php endfor; ?>
      </div>


    </main>
  </div>

  <script>
    lucide.createIcons();
  </script>
</body>

</html>