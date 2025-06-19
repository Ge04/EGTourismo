<?php 
include '../backend/conexion.php';

$json = array();

$sql = "SELECT * FROM hotel ORDER BY id ASC LIMIT 2";
$resultado = $conexion->query($sql);

while($fila = $resultado->fetch_assoc()) 
    $json[] = $fila;
echo json_encode($json);

?>