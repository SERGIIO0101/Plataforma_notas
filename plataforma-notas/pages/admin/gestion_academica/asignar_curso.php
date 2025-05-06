<?php
session_start();
include '../../../includes/conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Obtener la lista de profesores
$profesores = $pdo->query("SELECT id, nombre FROM usuarios WHERE rol = 'profesor'")->fetchAll(PDO::FETCH_ASSOC);

// Obtener la lista de cursos
$cursos = $pdo->query("SELECT id, nombre FROM cursos")->fetchAll(PDO::FETCH_ASSOC);

// Asignar cursos al profesor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $profesor_id = $_POST['profesor_id'];
    $curso_ids = $_POST['curso_ids'] ?? [];

    try {
        // Eliminar asignaciones previas del profesor
        $stmt = $pdo->prepare("DELETE FROM profesores_cursos WHERE profesor_id = ?");
        $stmt->execute([$profesor_id]);

        // Insertar nuevas asignaciones
        $stmt = $pdo->prepare("INSERT INTO profesores_cursos (profesor_id, curso_id) VALUES (?, ?)");
        foreach ($curso_ids as $curso_id) {
            $stmt->execute([$profesor_id, $curso_id]);
        }

        $_SESSION['success'] = 'Cursos asignados correctamente.';
        header('Location: asignar_curso.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al asignar los cursos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Asignar Cursos</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
<!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Gestión de Cursos</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../../controllers/logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>
<!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Opciones Administrativas</h3>
    <div class="menu-item">
      <button class="menu-toggle">Usuarios</button>
      <div class="submenu">
        <a href="../gestion_usuarios/registro.php">Registrar Usuario</a>
        <a href="../gestion_usuarios/ver_usuarios.php">Listar Usuarios</a>
        <a href="../gestion_usuarios/ver_notas.php">Notas</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Gestión de Cursos</button>
      <div class="submenu">
        <a href="crear_curso.php">Crear Curso</a>
        <a href="asignar_curso.php">Asignar Cursos</a>
        <a href="ver_cursos.php">Listar Cursos</a>
      </div>
    </div>
    <div class="menu-item">
      <button class="menu-toggle">Estadísticas</button>
      <div class="submenu">
        <a href="../estadisticas/ver_actividades.php">Ver Actividades</a>
        <a href="../estadisticas/historial_academico.php">Historial Académico</a>
      </div>
    </div>
  </aside>
  <div class="dashboard-content">
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="asignar_curso.php" method="POST">
      <label for="profesor_id">Seleccionar Profesor:</label>
      <select name="profesor_id" id="profesor_id" required>
        <option value="" disabled selected>Seleccione un profesor</option>
        <?php foreach ($profesores as $profesor): ?>
          <option value="<?php echo $profesor['id']; ?>"><?php echo htmlspecialchars($profesor['nombre']); ?></option>
        <?php endforeach; ?>
      </select>

      <label for="curso_ids">Seleccionar Cursos:</label>
      <div class="checkbox-group">
        <?php foreach ($cursos as $curso): ?>
          <label>
            <input type="checkbox" name="curso_ids[]" value="<?php echo $curso['id']; ?>">
            <?php echo htmlspecialchars($curso['nombre']); ?>
          </label>
        <?php endforeach; ?>
      </div>

      <button type="submit">Asignar Cursos</button>
    </form>
  </div>
</body>
<!-- Footer -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->
  <script src="../../../assets/scripts/script.js"></script>
</html>