<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'eg_tourism';

$conexion = new mysqli($host, $user, $password, $dbname);

if ($conexion->connect_error) {
    die('Error de conexión: ' . $conexion->connect_error);
}

// Opcional: establecer el conjunto de caracteres
$conexion->set_charset('utf8');
?>