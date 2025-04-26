<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Profesor</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>

  <!-- Encabezado -->
  <div class="dashboard-header">
    <h2>Bienvenido, Profesor<br><small>Panel de gestión académica</small></h2>
    <div class="user-menu">
      <img src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="usuario" />
      <button class="cerrar-sesion">Cerrar sesión</button>
    </div>
  </div>

  <!-- Menú lateral -->
  <aside class="sidebar">
    <h3>Menú</h3>

    <div class="menu-item">
      <button class="menu-toggle">Actividades</button>
      <div class="submenu">
        <a href="#">Subir notas</a>
        <a href="#">Ver actividades</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="menu-toggle">Desempeño</button>
      <div class="submenu">
        <a href="#">Informe general</a>
        <a href="#">Comparativas</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="menu-toggle">Calendario</button>
      <div class="submenu">
        <a href="#">Eventos</a>
        <a href="#">Fechas de entrega</a>
      </div>
    </div>

    <div class="menu-item">
      <button class="menu-toggle">Perfil</button>
      <div class="submenu">
        <a href="#">Datos personales</a>
        <a href="#">Cambiar contraseña</a>
      </div>
    </div>
  </aside>

  <!-- Contenido principal -->
  <div class="dashboard-content">
    <img src="../assets/image5.png" alt="Escudo institucional" />
  </div>

  <script src="../scripts/script.js"></script>
</body>
</html>
