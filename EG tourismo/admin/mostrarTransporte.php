<?php 
// include '../backend/conexion.php';

$json = array();

$sql = "SELECT * FROM transporte";
$resultado = $conexion->query($sql);

while($fila = $resultado->fetch_assoc()) 
    $json[] = $fila;
echo json_encode($json);

?>