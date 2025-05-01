<?php
session_start();
include '../../../includes/conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
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
    <h2>Gestión de Cursos<br><small>Lista de Cursos Disponibles</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>

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
</html>