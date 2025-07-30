<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Registro - SalesHub</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-blue-200 min-h-screen flex items-center justify-center font-sans text-gray-800">

  <div class="bg-white/90 backdrop-blur-md rounded-xl shadow-lg p-10 max-w-md w-full">
    <h2 class="text-3xl font-bold text-blue-700 mb-8 text-center">Crear Cuenta</h2>
    <form action="../Funciones/Inicios/Registro.php" method="POST" class="space-y-6">
      <div>
        <label for="username" class="block mb-2 text-blue-600 font-semibold">Nombre de Usuario</label>
        <input
          type="text"
          id="username"
          name="username"
          required
          placeholder="Juan Perez"
          class="w-full px-4 py-3 rounded-lg border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
        />
      </div>

      <div>
        <label for="email" class="block mb-2 text-blue-600 font-semibold">Correo Electrónico</label>
        <input
          type="email"
          id="email"
          name="email"
          required
          placeholder="usuario@correo.com"
          class="w-full px-4 py-3 rounded-lg border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
        />
      </div>

      <div>
        <label for="password" class="block mb-2 text-blue-600 font-semibold">Contraseña</label>
        <input
          type="password"
          id="password"
          name="password"
          required
          placeholder="••••••••"
          class="w-full px-4 py-3 rounded-lg border border-blue-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
        />
      </div>

      <button
        type="submit"
        class="w-full bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-lg font-semibold transition"
      >
        Registrarse
      </button>
    </form>

    <p class="mt-6 text-center text-gray-600">
      ¿Ya tenés cuenta?
      <a href="./Login.php" class="text-blue-600 hover:underline font-semibold">Iniciar sesión</a>
    </p>
  </div>

</body>
</html>
