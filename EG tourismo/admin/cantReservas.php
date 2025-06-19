<?php  
// include "../backend/classes/Admin.php";
// include "../backend/config.php";
include "../backend/conexion.php";

$sql = "SELECT MONTHNAME(fecha_reser) AS mes, COUNT(*) AS total
        FROM reserva
        GROUP BY mes, MONTH(fecha_reser)
        ORDER BY MONTH(fecha_reser)";
$result = mysqli_query($conexion,$sql);

$arsenio = array();
// $meses = [];
// $totales = [];
while ($row = mysqli_fetch_all($result, MYSQLI_ASSOC)) {
   $arsenio = $row;
}

echo json_encode($arsenio);
// mysqli_close($conexion);


?>