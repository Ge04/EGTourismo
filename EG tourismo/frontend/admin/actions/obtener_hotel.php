<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener el ID del hotel
    $hotel_id = $_GET['id'];

    // Obtener los datos del hotel
    $sql = "SELECT * FROM hotel WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotel = $result->fetch_assoc();

    if ($hotel) {
        // Convertir las características y imágenes de JSON a arrays
        $hotel['caracteristicas'] = explode(',', $hotel['caracteristicas']);
        $hotel['imagenes'] = json_decode($hotel['imagenes'], true);
        
        echo json_encode($hotel);
    } else {
        throw new Exception("Hotel no encontrado");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 