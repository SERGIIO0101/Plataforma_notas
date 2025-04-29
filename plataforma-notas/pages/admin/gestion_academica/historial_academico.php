<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
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
  <h2>Historial Académico</h2>
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
</body>
</html>