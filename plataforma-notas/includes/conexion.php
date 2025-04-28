<?php
// Conexion a la base de datos
$host = '127.0.0.1'; // o localhost
$db = 'plataforma_notas'; // Nombre de tu base de datos
$user = 'root'; // Tu usuario de la base de datos
$pass = ''; // Tu contraseña de la base de datos, si la tienes

try {
    // Creación de una instancia PDO para la conexión
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    // Configurar el modo de error de PDO para excepciones
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Si hay un error de conexión, lo mostramos
    die("Error de conexión: " . $e->getMessage());
}
?>

