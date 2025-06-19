<?php
// include "../backend/classes/Admin.php";
// include "../backend/config.php";
include "../backend/conexion.php";

$sql = "SELECT 
    z.nombre AS zona,
    COUNT(rz.reserva_id) AS total_visitantes
FROM 
    zona_turismo z
LEFT JOIN 
    reserva_zona rz ON z.id = rz.zona_id
GROUP BY 
    z.id, z.nombre
ORDER BY 
    total_visitantes DESC";
$result = mysqli_query($conexion, $sql);

$arsenio = array();
// $meses = [];
// $totales = [];
while ($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
    $arsenio = $row;
}

echo json_encode($arsenio);
// mysqli_close($conexion);
