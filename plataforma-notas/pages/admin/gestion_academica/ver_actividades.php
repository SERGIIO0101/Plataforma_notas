<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once '../includes/conexion.php';

// Consultas
$counts = [];
$roles = ['estudiante','profesor','admin'];
foreach($roles as $r) {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM usuarios WHERE rol = ?");
  $stmt->bind_param('s', $r);
  $stmt->execute();
  $stmt->bind_result($c); $stmt->fetch();
  $counts[$r] = $c;
  $stmt->close();
}
$totalMaterias = $conn->query("SELECT COUNT(*) AS c FROM materias")->fetch_assoc()['c'];
$totalNotas    = $conn->query("SELECT COUNT(*) AS c FROM notas")->fetch_assoc()['c'];
$totalEval     = $conn->query("SELECT COUNT(*) AS c FROM evaluaciones")->fetch_assoc()['c'];
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
  <?php include 'dashboard-admin-header.php'; ?>

  <div class="dashboard-content">
    <h2>Estadísticas Generales</h2>
    <ul class="stats-list">
      <li>Estudiantes: <?= $counts['estudiante'] ?></li>
      <li>Profesores:  <?= $counts['profesor'] ?></li>
      <li>Administradores: <?= $counts['admin'] ?></li>
      <li>Total materias: <?= $totalMaterias ?></li>
      <li>Total notas: <?= $totalNotas ?></li>
      <li>Total evaluaciones: <?= $totalEval ?></li>
    </ul>
  </div>

  <script src="../../../assets/scripts/script.js"></script>
</body>
</html>
