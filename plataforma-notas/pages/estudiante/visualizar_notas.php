<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser estudiante
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'estudiante') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../../login.php');
    exit;
}

// Obtener notas actuales del estudiante
try {
    $stmt = $pdo->prepare("
        SELECT m.nombre AS materia, n.nota 
        FROM notas n
        JOIN materias m ON n.materia_id = m.id
        WHERE n.usuario_id = :usuario_id
        ORDER BY m.nombre ASC
    ");
    $stmt->bindParam(':usuario_id', $_SESSION['usuario_id']);
    $stmt->execute();
    $notas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = 'Error al cargar las notas.';
    header('Location: ../../../dashboard-estudiante.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Visualizar Notas</title>
  <link rel="stylesheet" href="../../../assets/styles/styles.css">
</head>
<body>
<!-- Encabezado -->
    <div class="dashboard-header">
    <h2>Bienvenido, <?php echo $_SESSION['nombre']; ?><br><small>¿Qué quieres hacer?</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <form action="../../controllers/logout.php" method="post">
        <button type="submit" class="cerrar-sesion">Cerrar sesión</button>
      </form>
<!-- Contenido principal -->  
  <h2>Notas Actuales</h2>
  <table>
    <thead>
      <tr>
        <th>Materia</th>
        <th>Nota</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($notas as $nota): ?>
        <tr>
          <td><?php echo htmlspecialchars($nota['materia']); ?></td>
          <td><?php echo htmlspecialchars($nota['nota']); ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</body>
</html>