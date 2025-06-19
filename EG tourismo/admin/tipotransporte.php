<?php
// include "../backend/classes/Admin.php";
// include "../backend/config.php";
include "../backend/conexion.php";

$sql = "SELECT tipo_transporte, COUNT(*) AS cantidad
FROM transporte
GROUP BY tipo_transporte
ORDER BY cantidad DESC";
$result = mysqli_query($conexion, $sql);

$arsenio = array();
// $meses = [];
// $totales = [];
while ($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
    $arsenio = $row;
}

echo json_encode($arsenio);
mysqli_close($conexion);
?>