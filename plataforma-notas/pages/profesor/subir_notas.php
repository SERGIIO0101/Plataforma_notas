<?php
session_start();
include '../../includes/conexion.php';

// Verificar si el usuario es profesor
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'profesor') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
    exit;
}

// Obtener las materias asignadas al profesor
$stmt = $pdo->prepare("
    SELECT m.id, m.nombre 
    FROM materias m
    JOIN profesores_cursos pc ON m.curso_id = pc.curso_id
    WHERE pc.profesor_id = :profesor_id
");
$stmt->bindParam(':profesor_id', $_SESSION['usuario_id']);
$stmt->execute();
$materias = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Procesar el formulario de subida de notas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $materia_id = $_POST['materia_id'];
    $estudiante_id = $_POST['estudiante_id'];
    $periodo1 = $_POST['periodo1'] ?? null;
    $periodo2 = $_POST['periodo2'] ?? null;
    $periodo3 = $_POST['periodo3'] ?? null;
    $periodo4 = $_POST['periodo4'] ?? null;

    try {
        // Insertar o actualizar las notas
        $stmt = $pdo->prepare("
            INSERT INTO notas (usuario_id, materia_id, periodo1, periodo2, periodo3, periodo4)
            VALUES (:usuario_id, :materia_id, :periodo1, :periodo2, :periodo3, :periodo4)
            ON DUPLICATE KEY UPDATE
                periodo1 = VALUES(periodo1),
                periodo2 = VALUES(periodo2),
                periodo3 = VALUES(periodo3),
                periodo4 = VALUES(periodo4)
        ");
        $stmt->execute([
            ':usuario_id' => $estudiante_id,
            ':materia_id' => $materia_id,
            ':periodo1' => $periodo1,
            ':periodo2' => $periodo2,
            ':periodo3' => $periodo3,
            ':periodo4' => $periodo4
        ]);

        $_SESSION['success'] = 'Notas actualizadas correctamente.';
        header('Location: subir_notas.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al actualizar las notas.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Subir Notas</title>
  <link rel="stylesheet" href="../../assets/styles/styles.css">
</head>
<body>
 <!-- Encabezado -->
 <div class="dashboard-header">
    <h2>Bienvenido, Profesor <?php echo htmlspecialchars($_SESSION['nombre']); ?><br><small>Actividades</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../controllers/logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
    </div>
  </div>
<!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Menú</h3>
    <div class="menu-item">
      <button class="menu-toggle">Actividades</button>
      <div class="submenu">
        <a href="subir_notas.php">Subir Notas</a>
        <a href="ver_notas.php">Ver Actividades</a>
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

    <form action="subir_notas.php" method="POST">
      <label for="materia_id">Seleccionar Materia:</label>
      <select name="materia_id" id="materia_id" required>
        <option value="" disabled selected>Seleccione una materia</option>
        <?php foreach ($materias as $materia): ?>
          <option value="<?php echo $materia['id']; ?>"><?php echo htmlspecialchars($materia['nombre']); ?></option>
        <?php endforeach; ?>
      </select>

      <label for="estudiante_id">ID del Estudiante:</label>
      <input type="number" id="estudiante_id" name="estudiante_id" required>

      <label for="periodo1">Nota Periodo 1:</label>
      <input type="number" id="periodo1" name="periodo1" step="0.01" min="0" max="5">

      <label for="periodo2">Nota Periodo 2:</label>
      <input type="number" id="periodo2" name="periodo2" step="0.01" min="0" max="5">

      <label for="periodo3">Nota Periodo 3:</label>
      <input type="number" id="periodo3" name="periodo3" step="0.01" min="0" max="5">

      <label for="periodo4">Nota Periodo 4:</label>
      <input type="number" id="periodo4" name="periodo4" step="0.01" min="0" max="5">

      <button type="submit">Guardar Notas</button>
    </form>
  </div>
</body>
<!-- Pie de página -->
  <footer class="footer">
    <p>&copy; 2025 Plataforma de Notas. Todos los derechos reservados.</p>
  </footer>
<!-- Script -->
  <script src="../../assets/scripts/script.js"></script>
</html>