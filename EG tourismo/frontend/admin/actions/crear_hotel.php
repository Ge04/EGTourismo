<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $caracteristicas = isset($_POST['caracteristicas']) ? implode(',', $_POST['caracteristicas']) : '';

    // Procesar imágenes
    $imagenes = [];
    if (isset($_FILES['imagenes'])) {
        $uploadDir = '../../uploads/hoteles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['imagenes']['name'][$key];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExt;
            $uploadFile = $uploadDir . $newFileName;

            if (move_uploaded_file($tmp_name, $uploadFile)) {
                $imagenes[] = 'uploads/hoteles/' . $newFileName;
            }
        }
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO hoteles (nombre, ubicacion, habitaciones, precio, descripcion, caracteristicas, imagenes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $imagenesJson = json_encode($imagenes);
    $stmt->bind_param("ssiisss", $nombre, $ubicacion, $habitaciones, $precio, $descripcion, $caracteristicas, $imagenesJson);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Hotel creado exitosamente']);
    } else {
        throw new Exception("Error al crear el hotel");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 