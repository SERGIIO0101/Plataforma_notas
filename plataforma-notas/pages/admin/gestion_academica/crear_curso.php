<?php
session_start();
include '../../../includes/conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Procesar el formulario de creación de curso
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre']);
    $descripcion = trim($_POST['descripcion']);

    if (empty($nombre)) {
        $_SESSION['error'] = 'El nombre del curso es obligatorio.';
    } else {
        try {
            $stmt = $pdo->prepare("INSERT INTO cursos (nombre, descripcion) VALUES (?, ?)");
            $stmt->execute([$nombre, $descripcion]);
            $_SESSION['success'] = 'Curso creado correctamente.';
            header('Location: crear_curso.php');
            exit;
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error al crear el curso.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear Curso</title>
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
<!-- Contenido principal -->
    <div class="dashboard-content">
    <?php if (isset($_SESSION['success'])): ?>
      <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <form action="crear_curso.php" method="POST">
      <label for="nombre">Nombre del Curso:</label>
      <input type="text" id="nombre" name="nombre" required>

      <label for="descripcion">Descripción del Curso:</label>
      <textarea id="descripcion" name="descripcion" rows="4"></textarea>

      <button type="submit">Crear Curso</button>
    </form>
    </div>
</body>
<!-- Pie de página -->
  <footer class="footer">
  <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->  
  <script src="../../../assets/scripts/script.js"></script>
</html>