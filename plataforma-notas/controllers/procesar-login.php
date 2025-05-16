<?php
session_start();
include '../includes/conexion.php'; // Conexión a la base de datos

// Verificar token CSRF
if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
    $_SESSION['error_login'] = 'Token inválido. Por favor, vuelve a intentarlo.';
    header('Location: ../login.php');
    exit;
}

// Validar datos recibidos
if (isset($_POST['usuario']) && isset($_POST['password'])) {
    $usuarioInput = trim($_POST['usuario']);
    $passwordInput = $_POST['password'];

    if (!empty($usuarioInput) && !empty($passwordInput)) {
        try {
            // Consulta preparada
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :usuario OR nombre = :usuario LIMIT 1");
            $stmt->bindParam(':usuario', $usuarioInput);
            $stmt->execute();
            $usuario = $stmt->fetch();

            if ($usuario && password_verify($passwordInput, $usuario['password'])) {
                // Iniciar sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['rol'] = $usuario['rol'];

                // Redirigir según el rol
                switch ($usuario['rol']) {
                    case 'admin':
                        header('Location: ../pages/dashboard-admin.php');
                        break;
                    case 'profesor':
                        header('Location: ../pages/dashboard-profesor.php');
                        break;
                    case 'estudiante':
                        header('Location: ../pages/dashboard-estudiante.php');
                        break;
                    default:
                        $_SESSION['error_login'] = 'Rol no reconocido.';
                        header('Location: ../login.php');
                }
                exit;
            } else {
                $_SESSION['error_login'] = 'Usuario o contraseña incorrectos.';
                header('Location: ../login.php');
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['error_login'] = 'Error al conectar con la base de datos.';
            header('Location: ../login.php');
            exit;
        }
    } else {
        $_SESSION['error_login'] = 'Completa todos los campos.';
        header('Location: ../login.php');
        exit;
    }
} else {
    $_SESSION['error_login'] = 'Acceso no autorizado.';
    header('Location: ../login.php');
    exit;
}
