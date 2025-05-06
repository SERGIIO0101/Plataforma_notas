<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Obtener historial académico
try {
    $stmt = $pdo->query("SELECT u.nombre AS estudiante, m.nombre AS materia, n.nota, n.fecha 
                         FROM notas n
                         JOIN usuarios u ON n.usuario_id = u.id
                         JOIN materias m ON n.materia_id = m.id
                         ORDER BY n.fecha DESC");
    $historial = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar el historial académico.';
    header('Location: ../../dashboard-admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Historial Académico</title>
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
        <a href="gestion_usuarios/registro.php">Registrar Usuario</a>
        <a href="gestion_usuarios/ver_usuarios.php">Listar Usuarios</a>
        <a href="gestion_usuarios/ver_notas.php">Notas</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Gestión de Cursos</button>
      <div class="submenu">
        <a href="../gestion_academica/crear_curso.php">Crear Curso</a>
        <a href="../gestion_academica/asignar_curso.php">Asignar Cursos</a>
        <a href="../gestion_academica/ver_cursos.php">Listar Cursos</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Estadísticas</button>
      <div class="submenu">
        <a href="ver_actividades.php">Ver Actividades</a>
        <a href="historial_academico.php">Historial Académico</a>
      </div>
    </div>
  </aside> 
<!-- Contenido principal -->
  <div class="dashboard-content">
    <h2>Historial Académico</h2>
    <?php if (!empty($historial)): ?>
      <table>
        <thead>
          <tr>
            <th>Estudiante</th>
            <th>Materia</th>
            <th>Nota</th>
            <th>Fecha</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($historial as $registro): ?>
            <tr>
              <td><?php echo htmlspecialchars($registro['estudiante']); ?></td>
              <td><?php echo htmlspecialchars($registro['materia']); ?></td>
              <td><?php echo htmlspecialchars($registro['nota']); ?></td>
              <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay registros en el historial académico.</p>
    <?php endif; ?>
  </div>
</body>
<!-- Pie de página -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->
  <script src="../../../assets/scripts/script.js"></script>
</html>