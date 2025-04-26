<?php include("../includes/conexion.php"); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Registro de Usuario</title>
  <link rel="stylesheet" href="../style/styles.css" />
</head>
<body>
  <div class="form-contenedor">
    <form action="procesar-registro.php" method="POST">
      <h2>Registrar Nuevo Usuario</h2>

      <input type="text" name="nombre" placeholder="Nombre completo" required>
      <input type="email" name="email" placeholder="Correo institucional" required>
      <input type="password" name="password" placeholder="Contraseña" required>
      <select name="rol" required>
        <option value="">Seleccionar rol</option>
        <option value="estudiante">Estudiante</option>
        <option value="profesor">Profesor</option>
      </select>

      <button type="submit">Registrar Usuario</button>
    </form>
  </div>
</body>
</html>

