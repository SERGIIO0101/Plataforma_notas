<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header('Location: login.php');
    exit;
}
require_once '../includes/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)$_POST['user_id'];
    $newRole = $_POST['rol'];
    $stmt = $conn->prepare("UPDATE usuarios SET rol = ? WHERE id = ?");
    $stmt->bind_param('si', $newRole, $id);
    $stmt->execute();
    header('Location: cambiar_roles.php');
    exit;
}

$usuarios = $conn->query("SELECT id, nombre, email, rol FROM usuarios");
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Cambiar Roles - Admin</title>
  <link rel="stylesheet" href="../assets/styles/styles.css">
</head>
<body>
  <?php include 'dashboard-admin-header.php'; ?>

  <div class="dashboard-content">
    <h2>Cambiar Rol de Usuarios</h2>
    <table>
      <thead>
        <tr><th>Nombre</th><th>Email</th><th>Rol actual</th><th>Nuevo rol</th><th>Acción</th></tr>
      </thead>
      <tbody>
      <?php while($u = $usuarios->fetch_assoc()): ?>
        <tr>
          <form method="POST">
            <td><?= htmlspecialchars($u['nombre']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['rol'] ?></td>
            <td>
              <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
              <select name="rol" required>
                <option value="estudiante" <?= $u['rol']==='estudiante'?'selected':'' ?>>Estudiante</option>
                <option value="profesor"   <?= $u['rol']==='profesor'?'selected':'' ?>>Profesor</option>
                <option value="admin"      <?= $u['rol']==='admin'?'selected':'' ?>>Admin</option>
              </select>
            </td>
            <td><button type="submit">Guardar</button></td>
          </form>
        </tr>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script src="../assets/scripts/script.js"></script>
</body>
</html>
