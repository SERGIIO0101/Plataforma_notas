<?php
session_start();

// Generar un token CSRF si no existe
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Función para sanitizar entrada del usuario
function limpiarEntrada($dato) {
    return htmlspecialchars(trim($dato), ENT_QUOTES, 'UTF-8');
}

// Mostrar mensaje de logout (si existe)
if (isset($_SESSION['mensaje'])) {
    echo '<div class="mensaje-exito">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']); // Limpiar mensaje después de mostrarlo
}

// Mostrar mensaje de error (si existe)
if (isset($_SESSION['error'])) {
    echo '<div class="error">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Plataforma Notas</title>

    <!-- Estilos -->
    <link rel="stylesheet" href="assets/styles/base.css">
    <link rel="stylesheet" href="assets/styles/pages/login.css">
    <link rel="stylesheet" href="assets/styles/components.css">
    <link rel="stylesheet" href="assets/styles/layout.css">
    <!-- Puedes incluir íconos de Font Awesome si lo deseas -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

    <!-- Contenedor principal -->
    <div class="login-container">
        
        <!-- Panel izquierdo (formulario) -->
        <div class="login-info">
            <img src="assets/image/logo.png" alt="Logo de la plataforma">
            <h2>Iniciar Sesión</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="error" role="alert" aria-live="assertive">
                    <?php echo limpiarEntrada($_SESSION['error']); unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>

            <form action="controllers/procesar-login.php" method="POST" class="login-form">
              <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

              <div class="campo">
                <label for="usuario">Usuario</label>
                <input type="text" id="usuario" name="usuario" placeholder="Ingrese su usuario" required autocomplete="username">
              </div>

              <div class="campo">
                <label for="password">Contraseña</label>
                <div class="campo-password">
                  <input type="password" id="password" name="password" placeholder="Contraseña" required autocomplete="off">
                  <button type="button" class="toggle-password" title="Mostrar u ocultar contraseña">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <button type="submit">
                <i class="fas fa-arrow-right-to-bracket"></i> Entrar
              </button>
              <p class="form-error-msg" aria-live="polite"></p>

            </form>

            <p>¿Olvidaste tu contraseña? <a href="recuperar.php">Recupérala aquí</a></p>

            <section class="soporte">
                <p>¿Necesitas ayuda? WhatsApp: <strong>+57 315 215 70 34</strong></p>
            </section>
        </div>

        <!-- Panel derecho (imagen/banner) -->
        <div class="login-banner">
            <img src="assets/image/banner-login.png" alt="Imagen promocional del sistema">
        </div>

    </div>
  
    <!-- Scripts -->
  <script src="assets/scripts/script.js"></script>
</body>
</html>
