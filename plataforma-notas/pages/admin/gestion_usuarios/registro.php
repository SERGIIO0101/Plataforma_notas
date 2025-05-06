<?php
session_start();

// Generar un token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro de Usuarios</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
<!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Usuarios </small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../controllers/logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>
  <div class="contenedor">
    <h2>Registrar Nuevo Usuario</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success"><?php echo htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

<!-- Formulario de registro -->
    <form action="../../../controllers/procesar-registro.php" method="POST" class="form-registro">
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

      <label for="nombre">Nombre</label>
      <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>

      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" placeholder="usuario@ejemplo.com" required>

      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" placeholder="Contraseña" required>

      <label for="rol">Rol</label>
      <select id="rol" name="rol" required>
        <option value="" disabled selected>Selecciona un rol</option>
        <option value="admin">Administrador</option>
        <option value="profesor">Profesor</option>
        <option value="estudiante">Estudiante</option>
      </select>

      <button type="submit">Registrar Usuario</button>
    </form>
  </div>
</body>
<!-- Pie de página -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Scripts -->
  <script src="../../../assets/scripts/script.js"></script>
</html>