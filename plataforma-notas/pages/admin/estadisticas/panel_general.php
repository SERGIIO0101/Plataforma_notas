<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
    exit;
}

// Obtener estadísticas generales
try {
    $total_usuarios = $pdo->query("SELECT COUNT(*) AS total FROM usuarios")->fetch()['total'];
    $total_profesores = $pdo->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'profesor'")->fetch()['total'];
    $total_estudiantes = $pdo->query("SELECT COUNT(*) AS total FROM usuarios WHERE rol = 'estudiante'")->fetch()['total'];
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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Estadísticas Generales</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
  <h2>Estadísticas Generales</h2>
  <div class="dashboard-stats">
    <div class="stat-item">
      <h3>Usuarios Totales</h3>
      <p><?php echo $total_usuarios; ?></p>
    </div>
    <div class="stat-item">
      <h3>Profesores</h3>
      <p><?php echo $total_profesores; ?></p>
    </div>
    <div class="stat-item">
      <h3>Estudiantes</h3>
      <p><?php echo $total_estudiantes; ?></p>
    </div>
  </div>
</body>
</html>