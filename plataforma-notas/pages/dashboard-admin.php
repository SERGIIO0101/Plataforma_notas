<?php
session_start();
include '../includes/conexion.php';

// Función para verificar el rol y acceso del admin
function verificarAccesoAdmin() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
        $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
        header('Location: ../login.php');
        exit;
    }
}

// Verificamos si el usuario tiene acceso de admin
verificarAccesoAdmin();

try {
    $counts = [];
    $roles = ['estudiante', 'profesor', 'admin'];
    
    // Obtenemos el conteo de cada rol de forma más eficiente
    foreach ($roles as $r) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE rol = ?");
        $stmt->execute([$r]);
        $counts[$r] = $stmt->fetchColumn();
    }

    // Total de materias, cursos y notas
    $totalMaterias = $pdo->query("SELECT COUNT(*) AS c FROM materias")->fetch()['c'];
    $totalCursos = $pdo->query("SELECT COUNT(*) AS c FROM cursos")->fetch()['c'];
    $totalNotas = $pdo->query("SELECT COUNT(*) AS c FROM notas")->fetch()['c'];
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar las estadísticas: ' . $e->getMessage();
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
  <link rel="stylesheet" href="../assets/styles/base.css" />
  <link rel="stylesheet" href="../assets/styles/components.css" />
  <link rel="stylesheet" href="../assets/styles/layout.css" />
  <link rel="stylesheet" href="../assets/styles/pages/dashboard.css" />
</head>
<body>
  <div class="dashboard-layout">

    <!-- Header -->
    <header class="dashboard-header">
      <h2>Bienvenido, <?= htmlspecialchars($_SESSION['nombre']) ?><br><small>¿Qué quieres hacer?</small></h2>
      <div class="user-menu">
        <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
        <form action="../controllers/logout.php" method="post">
          <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
        </form>
      </div>
    </header>

    <!-- Contenedor principal (Sidebar + Main) -->
    <div class="dashboard-main">

      <!-- Sidebar -->
      <aside class="sidebar">
        <h3>Opciones Administrativas</h3>

        <div class="menu-item">
          <button class="menu-toggle">Usuarios</button>
          <div class="submenu">
            <a href="admin/gestion_usuarios/registro.php">Registrar Usuario</a>
            <a href="admin/gestion_usuarios/ver_usuarios.php">Listar Usuarios</a>
            <a href="admin/gestion_usuarios/ver_notas.php">Ver Notas</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="menu-toggle">Gestión de Cursos</button>
          <div class="submenu">
            <a href="admin/gestion_academica/crear_curso.php">Crear Curso</a>
            <a href="admin/gestion_academica/asignar_curso.php">Asignar Cursos</a>
            <a href="admin/gestion_academica/ver_cursos.php">Listar Cursos</a>
          </div>
        </div>

        <div class="menu-item">
          <button class="menu-toggle">Estadísticas</button>
          <div class="submenu">
            <a href="admin/estadisticas/ver_actividades.php">Ver Actividades</a>
            <a href="admin/estadisticas/historial_academico.php">Historial Académico</a>
          </div>
        </div>
      </aside>

      <!-- Contenido Principal -->
      <main class="dashboard-content">
        <!-- Mostrar logo institucional en lugar de estadísticas -->
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
