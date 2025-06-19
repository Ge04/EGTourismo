<?php
include "../backend/conexion.php";

$sql = "SELECT MONTHNAME(fecha_reser) AS mes, COUNT(id) AS total
        FROM reserva
        GROUP BY MONTH(fecha_reser)
        ORDER BY MONTH(fecha_reser)";
$result = $conexion->query($sql);

echo "<table border='1' cellpadding='5'>";
echo "<tr><th>Mes</th><th>Total de Reservas</th></tr>";
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['mes']) . "</td>";
        echo "<td>" . (int)$row['total'] . "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='2'>No hay datos de reservas.</td></tr>";
}
echo "</table>";
?>