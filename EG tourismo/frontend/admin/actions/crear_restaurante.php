<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener datos del formulario
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $tipo_cocina = $_POST['tipo_cocina'];
    $precio_promedio = $_POST['precio_promedio'];
    $descripcion = $_POST['descripcion'];
    $caracteristicas = isset($_POST['caracteristicas']) ? implode(',', $_POST['caracteristicas']) : '';

    // Procesar imágenes
    $imagenes = [];
    if (isset($_FILES['imagenes'])) {
        $uploadDir = '../../uploads/restaurantes/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['imagenes']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['imagenes']['name'][$key];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExt;
            $uploadFile = $uploadDir . $newFileName;

            if (move_uploaded_file($tmp_name, $uploadFile)) {
                $imagenes[] = 'uploads/restaurantes/' . $newFileName;
            }
        }
    }

    // Insertar en la base de datos
    $sql = "INSERT INTO restaurantes (nombre, ubicacion, tipo_cocina, precio_promedio, descripcion, caracteristicas, imagenes) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $imagenesJson = json_encode($imagenes);
    $stmt->bind_param("sssssss", $nombre, $ubicacion, $tipo_cocina, $precio_promedio, $descripcion, $caracteristicas, $imagenesJson);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Restaurante creado exitosamente']);
    } else {
        throw new Exception("Error al crear el restaurante");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 