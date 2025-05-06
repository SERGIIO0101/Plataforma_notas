<?php
session_start();
include '../../includes/conexion.php';

// Verificar si el usuario es profesor o administrador
if (!isset($_SESSION['usuario_id']) || !in_array($_SESSION['rol'], ['profesor', 'admin'])) {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
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
    header('Location: ../dashboard-profesor.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ver Notas</title>
  <link rel="stylesheet" href="../../assets/styles/styles.css">
</head>
<body>
 <!-- Encabezado -->
 <div class="dashboard-header">
    <h2>Bienvenido, Profesor <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Panel de gestión académica</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../controllers/logout.php" method="post">
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
        <a href="subir_notas.php">Subir Notas</a>
        <a href="ver_notas.php">Ver Actividades</a>
      </div>
    </div>
  </aside>
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
</body>
<!-- Pie de página -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->
  <script src="../../assets/scripts/script.js"></script>
</html>