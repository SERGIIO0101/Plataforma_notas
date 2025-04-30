<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Obtener actividades recientes
try {
    $stmt = $pdo->query("SELECT * FROM actividades ORDER BY fecha DESC LIMIT 10");
    $actividades = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar las actividades recientes.';
    header('Location: ../../dashboard-admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Actividad Reciente</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
  <h2>Actividad Reciente</h2>
  <table>
    <thead>
      <tr>
        <th>Usuario</th>
        <th>Acción</th>
        <th>Fecha</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($actividades as $actividad): ?>
        <tr>
          <td><?php echo htmlspecialchars($actividad['usuario']); ?></td>
          <td><?php echo htmlspecialchars($actividad['accion']); ?></td>
          <td><?php echo htmlspecialchars($actividad['fecha']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>