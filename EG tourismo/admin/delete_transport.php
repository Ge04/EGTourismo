<?php
require_once '../backend/config/config.php';
require_once '../backend/classes/Transport.php';

header('Content-Type: application/json');

try {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = intval($input['id'] ?? 0);
    
    if ($id <= 0) {
        throw new Exception('ID de transporte inválido');
    }
    
    $transport = new Transport();
    $result = $transport->deleteTransport($id);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Transporte eliminado exitosamente'
        ]);
    } else {
        throw new Exception('Error al eliminar el transporte');
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 