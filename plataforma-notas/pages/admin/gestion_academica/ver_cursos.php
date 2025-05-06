<?php
session_start();
include '../../../includes/conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Obtener la lista de cursos
try {
    $stmt = $pdo->query("SELECT id, nombre, descripcion FROM cursos ORDER BY nombre ASC");
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar los cursos.';
    header('Location: ../../dashboard-admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Cursos</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
<!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Gestión de Cursos</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../controllers/logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>
<!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Opciones Administrativas</h3>
    <div class="menu-item">
      <button class="menu-toggle">Usuarios</button>
      <div class="submenu">
        <a href="../gestion_usuarios/registro.php">Registrar Usuario</a>
        <a href="../gestion_usuarios/ver_usuarios.php">Listar Usuarios</a>
        <a href="../gestion_usuarios/ver_notas.php">Notas</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Gestión de Cursos</button>
      <div class="submenu">
        <a href="crear_curso.php">Crear Curso</a>
        <a href="asignar_curso.php">Asignar Cursos</a>
        <a href="ver_cursos.php">Listar Cursos</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Estadísticas</button>
      <div class="submenu">
        <a href="../estadisticas/ver_actividades.php">Ver Actividades</a>
        <a href="../estadisticas/historial_academico.php">Historial Académico</a>
      </div>
    </div>
  </aside>
  <!-- Contenido principal -->
  <div class="dashboard-content">
    <h2>Cursos Disponibles</h2>
    <?php if (!empty($cursos)): ?>
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Descripción</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($cursos as $curso): ?>
            <tr>
              <td><?php echo htmlspecialchars($curso['id']); ?></td>
              <td><?php echo htmlspecialchars($curso['nombre']); ?></td>
              <td><?php echo htmlspecialchars($curso['descripcion']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay cursos disponibles actualmente.</p>
    <?php endif; ?>
  </div>
</body>
<!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->
  <script src="../../../assets/scripts/script.js"></script>
</html>