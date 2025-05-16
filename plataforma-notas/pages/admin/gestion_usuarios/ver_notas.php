<?php
session_start();
include '../../../includes/conexion.php';

// Verificar si el usuario es profesor o administrador
if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Obtener las notas de los estudiantes
try {
    $stmt = $pdo->query("
        SELECT u.nombre AS estudiante, m.nombre AS materia, n.periodo1, n.periodo2, n.periodo3, n.periodo4, n.promedio
        FROM notas n
        JOIN usuarios u ON n.usuario_id = u.id
        JOIN materias m ON n.materia_id = m.id
        ORDER BY u.nombre ASC, m.nombre ASC
    ");
    $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar las notas.';
    header('Location: ../../dashboard-admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Notas</title>
    <link rel="stylesheet" href="../../../assets/styles/base.css">
    <link rel="stylesheet" href="../../../assets/styles/components.css">
    <link rel="stylesheet" href="../../../assets/styles/layout.css">
    <link rel="stylesheet" href="../../../assets/styles/pages/usuarios.css">
</head>
<body>

<!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Usuarios</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../controllers/logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>

<!-- Contenido principal -->
  <div class="dashboard-content">
    <h2>Notas de los Estudiantes</h2>
    <?php if (!empty($notas)): ?>
      <table>
        <thead>
          <tr>
            <th>Estudiante</th>
            <th>Materia</th>
            <th>Periodo 1</th>
            <th>Periodo 2</th>
            <th>Periodo 3</th>
            <th>Periodo 4</th>
            <th>Promedio</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($notas as $nota): ?>
            <tr>
              <td><?php echo htmlspecialchars($nota['estudiante']); ?></td>
              <td><?php echo htmlspecialchars($nota['materia']); ?></td>
              <td><?php echo htmlspecialchars($nota['periodo1']); ?></td>
              <td><?php echo htmlspecialchars($nota['periodo2']); ?></td>
              <td><?php echo htmlspecialchars($nota['periodo3']); ?></td>
              <td><?php echo htmlspecialchars($nota['periodo4']); ?></td>
              <td><?php echo htmlspecialchars($nota['promedio']); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No hay notas registradas actualmente.</p>
    <?php endif; ?>
  </div>
<!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Opciones Administrativas</h3>
    <div class="menu-item">
      <button class="menu-toggle">Usuarios</button>
      <div class="submenu">
        <a href="registro.php">Registrar Usuario</a>
        <a href="ver_usuarios.php">Listar Usuarios</a>
        <a href="ver_notas.php">Notas</a>
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
        <a href="../estadisticas/ver_actividades.php">Ver Actividades</a>
        <a href="../estadisticas/historial_academico.php">Historial Académico</a>
      </div>
    </div>
  </aside>
</body>
<!-- Pie de página -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->  
  <script src="../../../assets/scripts/script.js"></script>
</html>