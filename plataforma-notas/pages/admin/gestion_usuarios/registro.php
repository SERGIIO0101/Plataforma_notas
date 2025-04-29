<form action="../../../controllers/procesar-registro.php" method="POST" class="form-registro">
  <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
  <h2>Registrar Nuevo Usuario</h2>

  <label for="nombre">Nombre</label>
  <input type="text" id="nombre" name="nombre" placeholder="Nombre completo" required>

  <label for="email">Correo electrónico</label>
  <input type="email" id="email" name="email" placeholder="usuario@ejemplo.com" required>

  <label for="password">Contraseña</label>
  <input type="password" id="password" name="password" placeholder="Contraseña" required>

  <label for="rol">Rol</label>
  <select id="rol" name="rol" required>
    <option value="" disabled selected>Selecciona un rol</option>
    <option value="admin">Administrador</option>
    <option value="profesor">Profesor</option>
    <option value="estudiante">Estudiante</option>
  </select>

  <button type="submit">Registrar Usuario</button>
</form>
