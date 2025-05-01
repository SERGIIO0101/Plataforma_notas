<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
    exit;
}

// Obtener usuarios
try {
    $stmt = $pdo->query("SELECT id, nombre, email, rol FROM usuarios");
    $usuarios = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar los usuarios.';
    header('Location: ../../dashboard-admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Listar Usuarios</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
    <!-- Encabezado -->
    <div class="dashboard-header">
    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?><br><small>¿Qué quieres hacer?</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>
  <h2>Lista de Usuarios</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Email</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($usuarios as $usuario): ?>
        <tr>
          <td><?php echo htmlspecialchars($usuario['id']); ?></td>
          <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
          <td><?php echo htmlspecialchars($usuario['email']); ?></td>
          <td><?php echo htmlspecialchars($usuario['rol']); ?></td>
          <td>
            <a href="cambiar_roles.php?id=<?php echo $usuario['id']; ?>">Cambiar Rol</a>
            <a href="eliminar_usuarios.php?id=<?php echo $usuario['id']; ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?');">Eliminar</a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>