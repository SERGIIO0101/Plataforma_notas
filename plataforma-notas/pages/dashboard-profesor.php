<?php
session_start();
include '../includes/conexion.php';

function verificarAccesoProfesor() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'profesor') {
        $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
        header('Location: ../login.php');
        exit;
    }
}

verificarAccesoProfesor();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Profesor</title>
  <link rel="stylesheet" href="../assets/styles/base.css" />
  <link rel="stylesheet" href="../assets/styles/components.css" />
  <link rel="stylesheet" href="../assets/styles/layout.css" />
  <link rel="stylesheet" href="../assets/styles/pages/dashboard.css" />
</head>
<body>
  <div class="dashboard-layout">

    <!-- Header -->
    <header class="dashboard-header">
      <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?><br><small>Panel del Profesor</small></h2>
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
        <h3>Opciones del Profesor</h3>

        <div class="menu-item">
          <button class="menu-toggle">Notas</button>
          <div class="submenu">
            <a href="profesor/gestionar_notas.php">Gestionar Notas</a>
            <a href="profesor/ver_estudiantes.php">Ver Estudiantes</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="menu-toggle">Cursos</button>
          <div class="submenu">
            <a href="profesor/ver_cursos.php">Mis Cursos</a>
            <a href="profesor/asignar_notas.php">Asignar Notas</a>
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

