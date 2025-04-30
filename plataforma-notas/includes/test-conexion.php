<?php
include 'conexion.php';

if ($pdo) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar con la base de datos.";
}
?>