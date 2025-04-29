<?php
session_start();
include '../includes/conexion.php';

// Verificar CSRF token
if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
    $_SESSION['error'] = 'Token CSRF inválido.';
    header('Location: ../pages/admin/gestion_usuarios/registro.php');
    exit;
}

// Validar datos
$nombre = filter_var($_POST['nombre'], FILTER_SANITIZE_STRING);
$email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = $_POST['rol'];

if (!empty($nombre) && !empty($email) && !empty($password) && !empty($rol)) {
    try {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (:nombre, :email, :password, :rol)");
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':rol', $rol);
        $stmt->execute();

        $_SESSION['success'] = 'Usuario registrado exitosamente.';
        header('Location: ../pages/admin/gestion_usuarios/registro.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al registrar el usuario.';
        header('Location: ../pages/admin/gestion_usuarios/registro.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'Por favor completa todos los campos.';
    header('Location: ../pages/admin/gestion_usuarios/registro.php');
    exit;
}