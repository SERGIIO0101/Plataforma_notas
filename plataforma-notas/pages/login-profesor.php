<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap"/>
  <title>Login Profesor</title>
  <link rel="stylesheet" href="../styles/styles.css" />
</head>
<body>
  <div class="contenedor-imagen-form">
    <div class="imagen-login">
      <img src="../assets/image3.jpg" alt="Profesor enseñando" />
    </div>
    <div class="form-contenedor iniciar-sesion">
    <form action="procesar-login-profesor.php" method="POST">

        <h2>Iniciar Sesión</h2>
        <span>Usa tu cuenta de profesor</span>
        <input type="email" name="email" placeholder="Email" required />
        <input type="password" name="password" placeholder="Contraseña" required />
        <a href="#">¿Olvidaste tu contraseña?</a>
        <button type="submit">Iniciar Sesión</button>
      </form>
    </div>
  </div>
  <footer>
    <p>© 2025 Plataforma SIE. Todos los derechos reservados.</p>
  </footer>
  <script src="../scripts/script.js"></script>
</body>
</html>
