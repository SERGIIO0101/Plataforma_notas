<?php
session_start();
include '../includes/conexion.php';

function verificarAccesoEstudiante() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'estudiante') {
        $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
        header('Location: ../login.php');
        exit;
    }
}

verificarAccesoEstudiante();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Estudiante</title>
  <link rel="stylesheet" href="../assets/styles/base.css" />
  <link rel="stylesheet" href="../assets/styles/components.css" />
  <link rel="stylesheet" href="../assets/styles/layout.css" />
  <link rel="stylesheet" href="../assets/styles/pages/dashboard.css" />
</head>
<body>
  <div class="dashboard-layout">

    <!-- Header -->
    <header class="dashboard-header">
      <h2>Hola, <?= htmlspecialchars($_SESSION['nombre']) ?><br><small>Tu Panel de Estudiante</small></h2>
      <div class="user-menu">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
        <form action="../controllers/logout.php" method="post">
          <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
        </form>
      </div>
    </header>

    <!-- Contenedor principal -->
    <div class="dashboard-main">

      <!-- Sidebar -->
      <aside class="sidebar">
        <h3>Menú Estudiantil</h3>

        <div class="menu-item">
          <button class="menu-toggle">Mis Cursos</button>
          <div class="submenu">
            <a href="estudiante/ver_cursos.php">Ver Cursos</a>
            <a href="estudiante/material_apoyo.php">Material de Apoyo</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="menu-toggle">Notas</button>
          <div class="submenu">
            <a href="estudiante/mis_notas.php">Mis Notas</a>
            <a href="estudiante/historial_academico.php">Historial Académico</a>
          </div>
        </div>
      </aside>

      <!-- Contenido principal -->
      <main class="dashboard-content">
        <div class="logo-container">
          <img src="../assets/image/logo-institucional.png" alt="Logo Institucional" class="logo-institucional">
        </div>
      </main>

    </div> <!-- Fin de dashboard-main -->

    <!-- Footer -->
    <footer class="footer">
      <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
    </footer>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>
