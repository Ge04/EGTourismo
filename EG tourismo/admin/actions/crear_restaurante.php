<?php
require_once '../../backend/config/config.php';
require_once '../../backend/classes/Restaurant.php';

header('Content-Type: application/json');

try {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Invalid request method');
    }

    // Get form data
    $nombre = trim($_POST['nombre'] ?? '');
    $ubicacion = trim($_POST['ubicacion'] ?? '');
    $tipo_cocina = trim($_POST['tipo_cocina'] ?? '');
    $precio_medio = trim($_POST['precio_promedio'] ?? '');
    $descripcion = trim($_POST['descripcion'] ?? '');
    $horario = trim($_POST['horario'] ?? '');
    
    // Validate required fields
    if (empty($nombre) || empty($ubicacion) || empty($tipo_cocina) || empty($precio_medio)) {
        throw new Exception('Los campos nombre, ubicación, tipo de cocina y precio medio son obligatorios');
    }

    // Handle image upload
    $imagen = null;
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nomfoto = $_FILES['imagen']['name'];
        $dirtemp = $_FILES['imagen']['tmp_name'];
        $uploadDir = '../img/';
        
        // Create directory if it doesn't exist
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $arreglo = explode('.', $nomfoto);
        $extension_img = strtolower(end($arreglo));
        $extension_array_img = array('jpg', 'png', 'jpeg', 'gif');
        
        if (!in_array($extension_img, $extension_array_img)) {
            throw new Exception('Formato de imagen no válido. Use: jpg, png, jpeg, gif');
        }
        
        $imagen = time() . '_' . $nomfoto;
        $uploadPath = $uploadDir . $imagen;
        
        if (!move_uploaded_file($dirtemp, $uploadPath)) {
            throw new Exception('Error al subir la imagen');
        }
    }

    // Create restaurant data array
    $restaurantData = [
        'nombre' => $nombre,
        'ubicacion' => $ubicacion,
        'tipo_cocina' => $tipo_cocina,
        'precio_medio' => $precio_medio,
        'descripcion' => $descripcion,
        'horario' => $horario,
        'imagen' => $imagen
    ];

    // Create restaurant using the Restaurant class
    $restaurant = new Restaurant();
    $result = $restaurant->createRestaurant($restaurantData);
    
    if ($result) {
        echo json_encode([
            'success' => true,
            'message' => 'Restaurante registrado exitosamente'
        ]);
    } else {
        throw new Exception('Error al registrar el restaurante');
    }
    
} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
?> 