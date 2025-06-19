<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener el ID del hotel a eliminar
    $data = json_decode(file_get_contents('php://input'), true);
    $hotel_id = $data['id'];

    // Obtener las imágenes del hotel antes de eliminarlo
    $sql = "SELECT imagenes FROM hoteles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotel = $result->fetch_assoc();
    
    // Eliminar las imágenes del servidor
    if ($hotel && $hotel['imagenes']) {
        $imagenes = json_decode($hotel['imagenes'], true);
        foreach ($imagenes as $imagen) {
            $rutaImagen = '../../' . $imagen;
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
    }

    // Eliminar el hotel de la base de datos
    $sql = "DELETE FROM hoteles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hotel_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Hotel eliminado exitosamente']);
    } else {
        throw new Exception("Error al eliminar el hotel");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 