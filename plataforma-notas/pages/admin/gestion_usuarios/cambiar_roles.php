<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
    exit;
}

// Obtener el usuario por ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("SELECT id, nombre, rol FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$usuario) {
            $_SESSION['error'] = 'Usuario no encontrado.';
            header('Location: ver_usuarios.php');
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al cargar el usuario.';
        header('Location: ver_usuarios.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'ID de usuario no proporcionado.';
    header('Location: ver_usuarios.php');
    exit;
}

// Procesar el cambio de rol
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_rol = $_POST['rol'];
    try {
        $stmt = $pdo->prepare("UPDATE usuarios SET rol = :rol WHERE id = :id");
        $stmt->bindParam(':rol', $nuevo_rol);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $_SESSION['success'] = 'Rol actualizado correctamente.';
        header('Location: ver_usuarios.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al actualizar el rol.';
        header('Location: ver_usuarios.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cambiar Rol</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
  <h2>Cambiar Rol de Usuario</h2>
  <form method="POST">
    <p>Usuario: <?php echo htmlspecialchars($usuario['nombre']); ?></p>
    <label for="rol">Nuevo Rol</label>
    <select id="rol" name="rol" required>
      <option value="admin" <?php echo $usuario['rol'] === 'admin' ? 'selected' : ''; ?>>Administrador</option>
      <option value="profesor" <?php echo $usuario['rol'] === 'profesor' ? 'selected' : ''; ?>>Profesor</option>
      <option value="estudiante" <?php echo $usuario['rol'] === 'estudiante' ? 'selected' : ''; ?>>Estudiante</option>
    </select>
    <button type="submit">Actualizar Rol</button>
  </form>
</body>
</html>