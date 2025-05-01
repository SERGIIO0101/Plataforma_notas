<?php
session_start();
include '../includes/conexion.php';

// Verificar si hay sesión activa y que el usuario sea profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'profesor') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../login.php');
    exit;
}

// Obtener los cursos asignados al profesor
try {
    $stmt = $pdo->prepare("
        SELECT c.nombre AS curso, c.descripcion 
        FROM cursos c
        JOIN profesores_cursos pc ON c.id = pc.curso_id
        WHERE pc.profesor_id = :profesor_id
    ");
    $stmt->bindParam(':profesor_id', $_SESSION['usuario_id']);
    $stmt->execute();
    $cursos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error al obtener los cursos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Profesor</title>
  <link rel="stylesheet" href="../assets/styles/styles.css" />
</head>
<body>
  <!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, Profesor <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Panel de gestión académica</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../logout.php" method="post">
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
        <a href="profesor/subir_notas.php">Subir Notas</a>
        <a href="profesor/ver_notas.php">Ver Actividades</a>
      </div>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="dashboard-content">
    <h2>Cursos Asignados</h2>
    <?php if (!empty($cursos)): ?>
      <ul class="cursos-list">
        <?php foreach ($cursos as $curso): ?>
          <li>
            <h3><?php echo htmlspecialchars($curso['curso']); ?></h3>
            <p><?php echo htmlspecialchars($curso['descripcion']); ?></p>
          </li>
        <?php endforeach; ?>
      </ul>
    <?php else: ?>
      <p>No tienes cursos asignados actualmente.</p>
    <?php endif; ?>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>