<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['user_id'];
    if ($id !== $_SESSION['usuario_id']) {
        $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
    }
    header('Location: eliminar_usuario.php');
    exit;
}

$usuarios = $conn->query("SELECT id, nombre, email FROM usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Eliminar Usuarios - Admin</title>
  <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
  <?php include 'dashboard-admin-header.php'; ?>

  <div class="dashboard-content">
    <h2>Eliminar Usuarios</h2>
    <table>
      <thead><tr><th>Nombre</th><th>Email</th><th>Acción</th></tr></thead>
      <tbody>
      <?php while($u = $usuarios->fetch_assoc()): ?>
        <tr>
          <td><?= htmlspecialchars($u['nombre']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td>
            <?php if ($u['id'] !== $_SESSION['usuario_id']): ?>
            <form method="POST" style="display:inline">
              <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
              <button type="submit" onclick="return confirm('¿Eliminar este usuario?')">Eliminar</button>
            </form>
            <?php else: ?>
              — (tú)
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>
