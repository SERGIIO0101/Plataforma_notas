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
  <title>Iniciar Sesión - Plataforma Notas</title>
  <link rel="stylesheet" href="assets/styles/styles.css">
</head>
<body>

  <div class="contenedor-login">
    <h2>Bienvenido al Sistema Integral de Evaluaciones</h2>

    <!-- Mostrar mensaje de error si existe -->
    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="controllers/procesar-login.php" method="POST" class="form-login">
      <!-- Token CSRF -->
      <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

      <label for="email">Correo electrónico</label>
      <input type="email" id="email" name="email" placeholder="Correo electrónico" required>

      <label for="password">Contraseña</label>
      <input type="password" id="password" name="password" placeholder="Contraseña" required>

      <button type="submit">Iniciar Sesión</button>
    </form>

    <p>¿Olvidaste tu contraseña? Contacta al administrador.</p>
  </div>
  
</body>
</html>