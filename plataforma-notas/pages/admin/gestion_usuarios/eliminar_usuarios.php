<?php
session_start();
include '../../../includes/conexion.php';

// Protección: debe estar logueado y ser admin
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'admin') {
    $_SESSION['error'] = 'No tienes permisos para acceder a esta página.';
    header('Location: ../../login.php');
    exit;
}

// Eliminar usuario por ID
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    try {
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $_SESSION['success'] = 'Usuario eliminado correctamente.';
        header('Location: ver_usuarios.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['error'] = 'Error al eliminar el usuario.';
        header('Location: ver_usuarios.php');
        exit;
    }
} else {
    $_SESSION['error'] = 'ID de usuario no proporcionado.';
    header('Location: ver_usuarios.php');
    exit;
}
?>