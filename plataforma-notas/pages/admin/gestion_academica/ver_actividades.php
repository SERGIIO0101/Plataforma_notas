<?php
session_start();
// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
    exit;
}
require_once '../../../includes/conexion.php';

// Consultas
try {
    $counts = [];
    $roles = ['estudiante', 'profesor', 'admin'];
    foreach ($roles as $r) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE rol = ?");
        $stmt->execute([$r]);
        $counts[$r] = $stmt->fetchColumn();
    }

    $totalMaterias = $pdo->query("SELECT COUNT(*) AS c FROM materias")->fetch()['c'];
    $totalNotas = $pdo->query("SELECT COUNT(*) AS c FROM notas")->fetch()['c'];
    $totalEval = $pdo->query("SELECT COUNT(*) AS c FROM evaluaciones")->fetch()['c'];
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar las estadísticas.';
    header('Location: ../../dashboard-admin.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Estadísticas - Admin</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
  <!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>¿Qué quieres hacer?</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>

  <!-- Contenido principal -->
  <div class="dashboard-content">
    <h2>Estadísticas Generales</h2>
    <ul class="stats-list">
      <li>Estudiantes: <?= htmlspecialchars($counts['estudiante']) ?></li>
      <li>Profesores: <?= htmlspecialchars($counts['profesor']) ?></li>
      <li>Administradores: <?= htmlspecialchars($counts['admin']) ?></li>
      <li>Total materias: <?= htmlspecialchars($totalMaterias) ?></li>
      <li>Total notas: <?= htmlspecialchars($totalNotas) ?></li>
      <li>Total evaluaciones: <?= htmlspecialchars($totalEval) ?></li>
    </ul>
  </div>

  <script src="../../../assets/scripts/script.js"></script>
</body>
</html>