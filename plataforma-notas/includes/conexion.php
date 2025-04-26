<?php
// Configuración de la base de datos
$host = 'localhost'; // Servidor de la base de datos
$usuario = 'root';   // Usuario por defecto de MySQL en XAMPP
$clave = '';         // Sin contraseña por defecto en XAMPP
$base_de_datos = 'plataforma_notas'; // Nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $usuario, $clave, $base_de_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("La conexión ha fallado: " . $conn->connect_error);
} else {
    // echo "Conexión exitosa";
}
?>
