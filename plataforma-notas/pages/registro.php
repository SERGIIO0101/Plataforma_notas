<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Registro de Usuarios</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>
  <div class="contenedor">
    <div class="form-contenedor iniciar-sesion">
      <form action="../controllers/procesar-registro.php" method="POST">
        <h2>Registrar Nuevo Usuario</h2>

        <!-- Mostrar mensaje de error si existe -->
        <?php if (isset($_SESSION['error'])): ?>
          <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <input type="text" name="nombre" placeholder="Nombre completo" required />
        <input type="email" name="email" placeholder="Correo institucional" required />
        <input type="password" name="password" placeholder="Contraseña" required />
        
        <select name="rol" required>
          <option value="" disabled selected>Selecciona un rol</option>
          <option value="estudiante">Estudiante</option>
          <option value="profesor">Profesor</option>
        </select>

        <button type="submit">Registrar Usuario</button>
      </form>
    </div>
  </div>
  <footer>
    <p>© 2025 Plataforma SIE. Todos los derechos reservados.</p>
  </footer>
  <script src="../scripts/script.js"></script>
</body>
</html>
