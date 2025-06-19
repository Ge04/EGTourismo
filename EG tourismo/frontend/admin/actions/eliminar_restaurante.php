<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener el ID del restaurante a eliminar
    $data = json_decode(file_get_contents('php://input'), true);
    $restaurante_id = $data['id'];

    // Obtener las imágenes del restaurante antes de eliminarlo
    $sql = "SELECT imagenes FROM restaurantes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurante_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurante = $result->fetch_assoc();
    
    // Eliminar las imágenes del servidor
    if ($restaurante && $restaurante['imagenes']) {
        $imagenes = json_decode($restaurante['imagenes'], true);
        foreach ($imagenes as $imagen) {
            $rutaImagen = '../../' . $imagen;
            if (file_exists($rutaImagen)) {
                unlink($rutaImagen);
            }
        }
    }

    // Eliminar el restaurante de la base de datos
    $sql = "DELETE FROM restaurantes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurante_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Restaurante eliminado exitosamente']);
    } else {
        throw new Exception("Error al eliminar el restaurante");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 