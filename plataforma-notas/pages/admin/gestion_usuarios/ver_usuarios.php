<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once '../includes/conexion.php';

$sql = "SELECT id, nombre, email, rol, fecha_creacion FROM usuarios";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Listar Usuarios - Admin</title>
  <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
  <?php include 'dashboard-admin-header.php'; ?>

  <div class="dashboard-content">
    <h2>Listado de Usuarios</h2>
    <table>
      <thead>
        <tr>
          <th>ID</th><th>Nombre</th><th>Email</th><th>Rol</th><th>Creado</th>
        </tr>
      </thead>
      <tbody>
      <?php while($u = $result->fetch_assoc()): ?>
        <tr>
          <td><?= $u['id'] ?></td>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= $u['rol'] ?></td>
          <td><?= $u['fecha_creacion'] ?></td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>
