<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener datos del formulario
    $hotel_id = $_POST['hotel_id'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $habitaciones = $_POST['habitaciones'];
    $precio = $_POST['precio'];
    $descripcion = $_POST['descripcion'];
    $caracteristicas = isset($_POST['caracteristicas']) ? implode(',', $_POST['caracteristicas']) : '';

    // Obtener imágenes actuales
    $sql = "SELECT imagenes FROM hoteles WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $hotel_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $hotel = $result->fetch_assoc();
    $imagenesActuales = json_decode($hotel['imagenes'], true);

    // Procesar nuevas imágenes
    $nuevasImagenes = [];
    if (isset($_FILES['nuevas_imagenes'])) {
        $uploadDir = '../../uploads/hoteles/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['nuevas_imagenes']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['nuevas_imagenes']['name'][$key];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExt;
            $uploadFile = $uploadDir . $newFileName;

            if (move_uploaded_file($tmp_name, $uploadFile)) {
                $nuevasImagenes[] = 'uploads/hoteles/' . $newFileName;
            }
        }
    }

    // Combinar imágenes actuales con nuevas
    $imagenesFinales = array_merge($imagenesActuales, $nuevasImagenes);
    $imagenesJson = json_encode($imagenesFinales);

    // Actualizar en la base de datos
    $sql = "UPDATE hoteles SET 
            nombre = ?, 
            ubicacion = ?, 
            habitaciones = ?, 
            precio = ?, 
            descripcion = ?, 
            caracteristicas = ?, 
            imagenes = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssiisssi", $nombre, $ubicacion, $habitaciones, $precio, $descripcion, $caracteristicas, $imagenesJson, $hotel_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Hotel actualizado exitosamente']);
    } else {
        throw new Exception("Error al actualizar el hotel");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 