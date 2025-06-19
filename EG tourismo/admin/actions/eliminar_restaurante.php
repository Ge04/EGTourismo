<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Restaurant.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? null;
    
    if (!$id) {
        throw new Exception('ID de restaurante requerido');
    }

    $restaurant = new Restaurant();
    $result = $restaurant->deleteRestaurant($id);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Restaurante eliminado exitosamente'
        ]);
    } else {
        throw new Exception('Error al eliminar el restaurante');
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 