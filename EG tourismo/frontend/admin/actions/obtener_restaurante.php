<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener el ID del restaurante
    $restaurante_id = $_GET['id'];

    // Obtener los datos del restaurante
    $sql = "SELECT * FROM restaurantes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurante_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurante = $result->fetch_assoc();

    if ($restaurante) {
        // Convertir las características e imágenes de JSON a arrays
        $restaurante['caracteristicas'] = explode(',', $restaurante['caracteristicas']);
        $restaurante['imagenes'] = json_decode($restaurante['imagenes'], true);
        
        echo json_encode($restaurante);
    } else {
        throw new Exception("Restaurante no encontrado");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 