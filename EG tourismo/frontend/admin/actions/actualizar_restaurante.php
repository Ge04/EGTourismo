<?php
require_once '../../config/database.php';

header('Content-Type: application/json');

try {
    // Obtener datos del formulario
    $restaurante_id = $_POST['restaurante_id'];
    $nombre = $_POST['nombre'];
    $ubicacion = $_POST['ubicacion'];
    $tipo_cocina = $_POST['tipo_cocina'];
    $precio_promedio = $_POST['precio_promedio'];
    $descripcion = $_POST['descripcion'];
    $caracteristicas = isset($_POST['caracteristicas']) ? implode(',', $_POST['caracteristicas']) : '';

    // Obtener imágenes actuales
    $sql = "SELECT imagenes FROM restaurantes WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $restaurante_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $restaurante = $result->fetch_assoc();
    $imagenesActuales = json_decode($restaurante['imagenes'], true);

    // Procesar nuevas imágenes
    $nuevasImagenes = [];
    if (isset($_FILES['nuevas_imagenes'])) {
        $uploadDir = '../../uploads/restaurantes/';
        if (!file_exists($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        foreach ($_FILES['nuevas_imagenes']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['nuevas_imagenes']['name'][$key];
            $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $newFileName = uniqid() . '.' . $fileExt;
            $uploadFile = $uploadDir . $newFileName;

            if (move_uploaded_file($tmp_name, $uploadFile)) {
                $nuevasImagenes[] = 'uploads/restaurantes/' . $newFileName;
            }
        }
    }

    // Combinar imágenes actuales con nuevas
    $imagenesFinales = array_merge($imagenesActuales, $nuevasImagenes);
    $imagenesJson = json_encode($imagenesFinales);

    // Actualizar en la base de datos
    $sql = "UPDATE restaurantes SET 
            nombre = ?, 
            ubicacion = ?, 
            tipo_cocina = ?, 
            precio_promedio = ?, 
            descripcion = ?, 
            caracteristicas = ?, 
            imagenes = ? 
            WHERE id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssi", $nombre, $ubicacion, $tipo_cocina, $precio_promedio, $descripcion, $caracteristicas, $imagenesJson, $restaurante_id);
    
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Restaurante actualizado exitosamente']);
    } else {
        throw new Exception("Error al actualizar el restaurante");
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

$conn->close();
?> 