<?php
session_start();
include '../includes/conexion.php';

// Verificar si hay sesión activa y que el usuario sea administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
  header('Location: ../login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Administrador</title>
  <link rel="stylesheet" href="../assets/styles/styles.css" />
</head>
<body>

  <!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Panel de Administración<br><small>Bienvenido, <?php echo $_SESSION['nombre']; ?></small></h2>
    <div class="user-menu">
      <!-- Imagen de perfil del usuario -->
      <img src="https://cdn-icons-png.flaticon.com/512/456/456212.png" alt="admin" />
      <!-- Menú desplegable -->
      <div class="menu-plegable">
        <a href="perfil.php">Ver perfil</a>
        <form action="../logout.php" method="post">
          <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Opciones administrativas</h3>

    <div class="menu-item">
      <button class="menu-toggle">Usuarios</button>
      <div class="submenu">
        <a href="registro.php">Registrar usuario</a>
        <a href="listar_usuarios.php">Listar usuarios</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="menu-toggle">Gestión</button>
      <div class="submenu">
        <a href="cambiar_roles.php">Cambiar roles</a>
        <a href="eliminar_usuario.php">Eliminar cuenta</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="menu-toggle">Estadísticas</button>
      <div class="submenu">
        <a href="estadisticas.php">Panel general</a>
        <a href="actividad_reciente.php">Actividad reciente</a>
      </div>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="dashboard-content">
    <img src="../assets/image5.png" alt="Escudo institucional" />
    <p style="margin-top: 30px; font-weight: bold;">Sistema Integral de Evaluaciones - Administración</p>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>
