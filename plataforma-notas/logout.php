<?php
session_start();  // Iniciar la sesión

// Destruir todas las variables de sesión
session_unset();

// Destruir la sesión
session_destroy();

// Redirigir al login después de cerrar sesión
header('Location: login.php');
exit;
?>
