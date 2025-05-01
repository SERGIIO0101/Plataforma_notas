<?php
session_start();
include '../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../login.php');
    exit;
}

// Obtener estadísticas rápidas
try {
    $total_usuarios = $pdo->query("SELECT COUNT(*) AS total FROM usuarios")->fetch()['total'];
    $total_profesores = $pdo->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'profesor'")->fetch()['total'];
    $total_estudiantes = $pdo->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'estudiante'")->fetch()['total'];
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar las estadísticas.';
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
    <h2>Panel de Administración<br>
       <small>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?></small>
    </h2>
    <div class="user-menu">
      <img src="../assets/image4.jpg" alt="admin" />
      <a href="../logout.php" class="cerrar-sesion">Cerrar sesión</a>
    </div>
  </div>

  <!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Opciones administrativas</h3>
    <div class="menu-item">
      <button class="menu-toggle">Usuarios</button>
      <div class="submenu">
        <a href="admin/gestion_usuarios/registro.php">Registrar usuario</a>
        <a href="admin/gestion_usuarios/ver_usuarios.php">Listar usuarios</a>
        <a href="admin/gestion_usuarios/cambiar_roles.php">Cambiar roles</a>
        <a href="admin/gestion_usuarios/eliminar_usuarios.php">Eliminar cuenta</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Gestión Académica</button>
      <div class="submenu">
        <a href="admin/gestion_academica/historial_academico.php">Historial académico</a>
        <a href="admin/gestion_academica/ver_actividades.php">Ver actividades</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Estadísticas</button>
      <div class="submenu">
        <a href="admin/estadisticas/panel_general.php">Panel general</a>
        <a href="admin/estadisticas/actividad_reciente.php">Actividad reciente</a>
      </div>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="dashboard-content">
    <div class="dashboard-stats">
      <div class="stat-item">
        <h3>Usuarios Totales</h3>
        <p><?php echo $total_usuarios; ?></p>
      </div>
      <div class="stat-item">
        <h3>Profesores</h3>
        <p><?php echo $total_profesores; ?></p>
      </div>
      <div class="stat-item">
        <h3>Estudiantes</h3>
        <p><?php echo $total_estudiantes; ?></p>
      </div>
    </div>
    <div class="welcome-message">
      <p>Utiliza el menú lateral para gestionar usuarios, roles y estadísticas del sistema.</p>
    </div>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>