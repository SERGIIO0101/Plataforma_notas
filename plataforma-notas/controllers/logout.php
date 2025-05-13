<?php
session_start();

// Limpiar variables de sesión
$_SESSION = [];

// Destruir la cookie de sesión si existe
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Destruir la sesión
session_destroy();

// Iniciar una nueva sesión solo para mostrar el mensaje
session_start();
$_SESSION['mensaje'] = 'Sesión cerrada correctamente.';

// Redirigir al login
header('Location: ../login.php');
exit;
?>
