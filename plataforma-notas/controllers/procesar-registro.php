<?php
session_start();
include '../includes/conexion.php';

// Verificar que los datos necesarios estén presentes
if (isset($_POST['nombre'], $_POST['email'], $_POST['password'], $_POST['rol'])) {
  $nombre = $_POST['nombre'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $rol = $_POST['rol'];

  // Validar que el correo no esté registrado previamente
  $stmt = $conn->prepare("SELECT * FROM usuarios WHERE email = ?");
  $stmt->bind_param("s", $email);
  $stmt->execute();
  $resultado = $stmt->get_result();

  if ($resultado->num_rows > 0) {
    $_SESSION['error'] = 'El correo electrónico ya está registrado.';
    header('Location: ../pages/registro.php');
    exit;
  }

  // Encriptar la contraseña antes de almacenarla
  $password_hash = password_hash($password, PASSWORD_BCRYPT);

  // Insertar el nuevo usuario en la base de datos
  $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, ?)");
  $stmt->bind_param("ssss", $nombre, $email, $password_hash, $rol);

  if ($stmt->execute()) {
    $_SESSION['success'] = 'Usuario registrado exitosamente.';
    header('Location: ../pages/login.php');
    exit;
  } else {
    $_SESSION['error'] = 'Hubo un problema al registrar el usuario. Intenta nuevamente.';
    header('Location: ../pages/registro.php');
    exit;
  }
} else {
  $_SESSION['error'] = 'Por favor, completa todos los campos.';
  header('Location: ../pages/registro.php');
  exit;
}
