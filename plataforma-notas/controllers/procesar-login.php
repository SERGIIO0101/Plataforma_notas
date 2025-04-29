<?php
session_start();
include '../includes/conexion.php'; // Conexión a la base de datos

// Verificar si se recibieron los datos por POST
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Validar que el correo y la contraseña no estén vacíos
    if (!empty($email) && !empty($password)) {
        try {
            // Consulta SQL para verificar si el usuario existe
            $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            $usuario = $stmt->fetch();

            // Verificar si el usuario fue encontrado
            if ($usuario) {
                // Verificar si la contraseña es correcta
                if (password_verify($password, $usuario['password'])) {
                    // Iniciar sesión y guardar la información del usuario
                    $_SESSION['usuario_id'] = $usuario['id'];
                    $_SESSION['nombre'] = $usuario['nombre'];
                    $_SESSION['email'] = $usuario['email'];
                    $_SESSION['rol'] = $usuario['rol']; // Establecer el rol (admin, estudiante, profesor)

                    // Redirigir según el rol del usuario
                    if ($usuario['rol'] === 'admin') {
                        header('Location: ../pages/dashboard-admin.php');
                    } elseif ($usuario['rol'] === 'profesor') {
                        header('Location: ../pages/dashboard-profesor.php');
                    } elseif ($usuario['rol'] === 'estudiante') {
                        header('Location: ../pages/dashboard-estudiante.php');
                    }
                    exit;
                } else {
                    // Contraseña incorrecta
                    $_SESSION['error'] = 'Contraseña incorrecta';
                    header('Location: ../login.php');
                    exit;
                }
            } else {
                // Usuario no encontrado
                $_SESSION['error'] = 'Correo electrónico no registrado';
                header('Location: ../login.php');
                exit;
            }
        } catch (PDOException $e) {
            $_SESSION['error'] = 'Error al consultar la base de datos.';
            header('Location: ../login.php');
            exit;
        }
    } else {
        // Si los campos están vacíos
        $_SESSION['error'] = 'Por favor completa todos los campos';
        header('Location: ../login.php');
        exit;
    }
} else {
    // Si no se recibieron los datos de formulario
    $_SESSION['error'] = 'Acceso no autorizado';
    header('Location: ../login.php');
    exit;
}