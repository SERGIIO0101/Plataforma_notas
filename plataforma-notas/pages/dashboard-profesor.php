<?php
session_start();
include '../includes/conexion.php';

// Verificar si hay sesión activa y que el usuario sea profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'profesor') {
  header('Location: ../login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Profesor</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>

  <!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, Profesor <?php echo $_SESSION['nombre']; ?><br><small>Panel de gestión académica</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>

  <!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Menú</h3>

    <div class="menu-item">
      <button class="menu-toggle">Actividades</button>
      <div class="submenu">
        <a href="subir_notas.php">Subir notas</a>
        <a href="ver_actividades.php">Ver actividades</a>
      </div>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="dashboard-content">
    <img src="../assets/image5.png" alt="Escudo institucional" />
  </div>

  <script src="../scripts/script.js"></script>
</body>
</html>
